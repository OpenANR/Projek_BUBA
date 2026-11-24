/**
 * WRITE TEST (opsional)
 * Menguji alur yang MENULIS data:
 *   1. login web siswa (POST /login)
 *   2. mengumpulkan jawaban kuis lewat web (POST /siswa/.../kuis-hasil)
 *   3. logout web (POST /logout)
 *   4. login API (POST /api/login)
 *   5. submit kuis lewat API (POST /api/siswa/kuis/submit)
 *   6. logout API (POST /api/logout)
 *
 * PERINGATAN:
 * - Test ini menambah baris pada tabel `rewards` dan `personal_access_tokens`.
 * - Jawaban sengaja dibuat SALAH agar bintang 0 dan kategori tidak terkunci.
 * - Jalankan pada database salinan/staging. Reset dengan:
 *     php artisan migrate:fresh --seed
 *
 * Jalankan:
 *   k6 run -e BASE_URL=http://localhost:8000 tests/k6/write.js
 *   WRITE_VUS=5 k6 run tests/k6/write.js
 */

import { check, group, sleep } from 'k6';
import { envInt, STUDENT, STUDENT_POOL, randomStudent } from './config.js';
import { teardownState } from './lib/state.js';
import { webLogin, apiLogin, apiLogout, apiHeaders } from './lib/auth.js';
import {
  get,
  post,
  jsonRequest,
  extractHiddenById,
  safeJson,
} from './lib/common.js';
import {
  discoverStudentData,
  fallbackStudentData,
} from './lib/discovery.js';

const WRITE_VUS = envInt('WRITE_VUS', 3);

export const options = {
  scenarios: {
    write_flow: {
      executor: 'per-vu-iterations',
      exec: 'writeFlow',
      vus: WRITE_VUS,
      iterations: 1,
      maxDuration: '2m',
    },
  },
  thresholds: {
    checks: ['rate>0.90'],
  },
  tags: { testid: 'write' },
};

export function setup() {
  // Login API sekali hanya untuk discovery data, lalu token langsung dihapus.
  let token = __ENV.API_TOKEN || null;

  if (!token) {
    let login = apiLogin(STUDENT);
    if (!login.token && login.res.status === 429) {
      login = apiLogin(randomStudent());
    }
    token = login.token;
  }

  const student = token ? discoverStudentData(token) : fallbackStudentData();

  if (token && !__ENV.API_TOKEN) {
    apiLogout(token);
  }

  return {
    baseUrl: __ENV.BASE_URL || 'http://localhost:8000',
    student,
    admin: {},
    adminSession: null,
    studentSession: null,
    apiToken: null,
    tokenFromEnv: true,
    apiHeaders: null,
    assets: { core: [], all: [] },
  };
}

export function teardown(state) {
  teardownState(state);
}

function wrongAnswer(answer) {
  return answer === 'A' ? 'B' : 'A';
}

function parseQuestions(html) {
  const questions = [];
  const regex = /data-id="(\d+)"\s+data-answer="([A-D])"/g;
  let match;

  while ((match = regex.exec(html)) !== null) {
    questions.push({ id: match[1], answer: match[2] });
  }

  return questions;
}

export function writeFlow(state) {
  const account = STUDENT_POOL[(__VU - 1) % STUDENT_POOL.length];
  const student = state.student || {};

  let csrf = null;

  group('write: login web siswa', () => {
    const login = webLogin(account, '/siswa/welcome');
    csrf = login.csrf;

    check(login.res, {
      'login web -> sukses': () => login.ok,
    });
  });

  if (!csrf) {
    check(false, { 'csrf web tersedia': () => false });
    return;
  }

  group('write: submit kuis lewat web', () => {
    if (!student.kelasNama || !student.kategoriSlug || !student.quizKode) {
      check(false, { 'data kuis web tersedia': () => false });
      return;
    }

    const quizPath =
      `/siswa/materi/kuis-show/${student.kelasNama}/` +
      `${student.kategoriSlug}/${student.quizKode}`;

    const page = get(quizPath, { tags: { name: 'GET /siswa/kuis-show (write)' } });
    check(page, { 'halaman kuis web -> 200': (r) => r.status === 200 });

    const questions = parseQuestions(page.body || '');
    check(page, {
      'halaman kuis web -> soal ditemukan': () => questions.length > 0,
    });

    if (!questions.length) return;

    csrf =
      extractHiddenById(page.body, 'csrfTokenBuba') ||
      (page.body || '').match(/name="csrf-token"[^>]*content="([^"]+)"/)?.[1] ||
      csrf;

    const jawaban = {};
    questions.forEach((question) => {
      jawaban[question.id] = wrongAnswer(question.answer);
    });

    const submitPath =
      `/siswa/materi/kuis-hasil/${student.kelasNama}/` +
      `${student.kategoriSlug}/${student.quizKode}`;

    const res = jsonRequest('POST', submitPath, { jawaban }, {
      headers: {
        'X-CSRF-TOKEN': csrf,
        'X-Requested-With': 'XMLHttpRequest',
      },
      tags: { name: 'POST /siswa/kuis-hasil (write)' },
    });

    const body = safeJson(res) || {};

    check(res, {
      'submit kuis web -> 200': (r) => r.status === 200,
      'submit kuis web -> success=true': () => body.success === true,
      'submit kuis web -> bintang 0': () => body.jumlah_bintang === 0,
    });
  });

  group('write: logout web', () => {
    const res = post(
      '/logout',
      { _token: csrf },
      {
        redirects: 0,
        tags: { name: 'POST /logout (write)' },
      }
    );

    check(res, {
      'logout web -> 302': (r) => r.status === 302,
    });
  });

  group('write: login API', () => {
    const login = apiLogin(account);

    check(login.res, {
      'login api -> sukses': (r) => r.status === 200,
      'login api -> token ada': () => !!login.token,
    });

    if (!login.token) return;

    const headers = apiHeaders(login.token);

    group('write: submit kuis lewat API', () => {
      if (!student.kelasId || !student.kategoriId) {
        check(false, { 'data kuis API tersedia': () => false });
        apiLogout(login.token);
        return;
      }

      const listRes = get(
        `/api/siswa/kuis?kelas_id=${student.kelasId}&kategori_id=${student.kategoriId}`,
        { headers, tags: { name: 'GET /api/siswa/kuis (write)' } }
      );
      const listBody = safeJson(listRes) || {};
      const daftar = listBody.data || [];

      check(listRes, {
        'daftar kuis API -> 200': (r) => r.status === 200,
        'daftar kuis API -> ada soal': () => daftar.length > 0,
      });

      if (daftar.length) {
        const jawaban = {};
        // Jawaban "B" untuk semua soal: pada data seed jawaban benar adalah A,
        // sehingga skor 0 dan kategori tidak terkunci.
        daftar.forEach((soal) => {
          jawaban[String(soal.id)] = 'B';
        });

        const submitRes = jsonRequest(
          'POST',
          '/api/siswa/kuis/submit',
          {
            quis_id: daftar[0].id,
            kelas_id: student.kelasId,
            kategori_id: student.kategoriId,
            jawaban,
          },
          { headers, tags: { name: 'POST /api/siswa/kuis/submit (write)' } }
        );

        const submitBody = safeJson(submitRes) || {};

        check(submitRes, {
          'submit kuis API -> 200/403 terkunci': (r) =>
            r.status === 200 || r.status === 403,
          'submit kuis API -> respons konsisten': () =>
            submitRes.status === 200
              ? submitBody.success === true
              : submitBody.terkunci === true,
        });
      }

      apiLogout(login.token);
    });
  });

  sleep(1);
}
