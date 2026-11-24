/**
 * Pembuatan state global saat setup().
 * Login dilakukan sekali, lalu cookie session dibagikan ke seluruh VU.
 * Ini menghindari rate limit login (5x/menit per email+IP) saat load test.
 */

import { check } from 'k6';
import { ADMIN, randomStudent } from '../config.js';
import { webLogin, apiLogin, apiLogout, apiHeaders } from './auth.js';
import { get, applySession, clearSession } from './common.js';
import {
  discoverAssets,
  discoverAdminData,
  discoverStudentData,
  fallbackStudentData,
} from './discovery.js';

/**
 * @param {object} options
 * @param {boolean} options.withAdmin  ikut login & discovery admin
 * @param {boolean} options.withStudent ikut login & discovery siswa
 */
export function buildState(options = {}) {
  const { withAdmin = true, withStudent = true } = options;

  let studentSession = null;
  let adminSession = null;
  let apiToken = __ENV.API_TOKEN || null;
  const tokenFromEnv = !!__ENV.API_TOKEN;

  /* ---------- Login web siswa ---------- */
  if (withStudent) {
    const login = webLogin(randomStudent(), '/siswa/welcome');
    if (login.ok) {
      studentSession = login.session;
    } else {
      console.warn(
        `[setup] Login web siswa gagal (status ${login.res.status}). ` +
          'Cek STUDENT_EMAIL/STUDENT_PASSWORD atau rate limit login.'
      );
    }
  }

  /* ---------- Login web admin ---------- */
  if (withAdmin) {
    const login = webLogin(ADMIN, '/admin/dashboard');
    if (login.ok) {
      adminSession = login.session;
    } else {
      console.warn(
        `[setup] Login web admin gagal (status ${login.res.status}). ` +
          'Cek ADMIN_EMAIL/ADMIN_PASSWORD atau rate limit login.'
      );
    }
  }

  /* ---------- Discovery data admin (cookie admin masih aktif) ---------- */
  let adminData = {};
  if (adminSession) {
    applySession(adminSession);
    const dashboard = get('/admin/dashboard', {
      tags: { name: 'SETUP dashboard admin' },
    });

    if (dashboard.status !== 200) {
      console.warn(
        `[setup] Session admin tidak valid (GET /admin/dashboard = ${dashboard.status}).`
      );
      adminSession = null;
    } else {
      adminData = discoverAdminData();
    }
  }

  /* ---------- Login API siswa ---------- */
  let studentData = fallbackStudentData();
  if (apiToken) {
    studentData = discoverStudentData(apiToken);
  } else if (withStudent) {
    // Rotasi akun untuk menghindari rate limit 5x/menit per email+IP.
    let login = apiLogin(randomStudent());
    if (!login.token && login.res.status === 429) {
      login = apiLogin(randomStudent());
    }

    if (login.token) {
      apiToken = login.token;
      studentData = discoverStudentData(apiToken);
    } else {
      console.warn(
        `[setup] Login API gagal (status ${login.res.status}). ` +
          'Menggunakan data fallback; test API akan dilewati.'
      );
    }
  }

  /* ---------- Aset statis ---------- */
  const assets = discoverAssets();

  applySession(null);
  clearSession();

  const state = {
    baseUrl: __ENV.BASE_URL || 'http://localhost:8000',
    assets,
    admin: withAdmin ? adminData : {},
    adminSession,
    student: withStudent ? studentData : {},
    studentSession,
    apiToken,
    tokenFromEnv,
    apiHeaders: apiToken ? apiHeaders(apiToken) : null,
  };

  check(state, {
    'setup: aset CSS ditemukan': (s) => !!s.assets.css,
    'setup: aset JS ditemukan': (s) => !!s.assets.js,
    'setup: session siswa tersedia': (s) => (withStudent ? !!s.studentSession : true),
    'setup: session admin tersedia': (s) => (withAdmin ? !!s.adminSession : true),
  });

  return state;
}

/** Teardown: hapus token API yang dibuat saat setup. */
export function teardownState(state) {
  if (state && state.apiToken && !state.tokenFromEnv) {
    apiLogout(state.apiToken);
  }
}

/** Data minimal untuk test yang tidak butuh login. */
export function publicState() {
  return {
    baseUrl: __ENV.BASE_URL || 'http://localhost:8000',
    assets: discoverAssets(),
    admin: {},
    adminSession: null,
    student: {},
    studentSession: null,
    apiToken: null,
    tokenFromEnv: true,
    apiHeaders: null,
  };
}
