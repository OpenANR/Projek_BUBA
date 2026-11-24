/**
 * SMOKE TEST
 * Satu VU, satu iterasi: memastikan seluruh halaman & endpoint utama hidup.
 *
 * Jalankan:
 *   k6 run -e BASE_URL=http://localhost:8000 tests/k6/smoke.js
 */

import { group } from 'k6';
import { check } from 'k6';
import { randomStudent } from './config.js';
import { buildState, teardownState } from './lib/state.js';
import { apiLogin, apiLogout } from './lib/auth.js';
import { expectStatus } from './lib/common.js';
import {
  publicJourney,
  publicExtrasJourney,
  studentJourney,
  adminJourney,
  adminPdfJourney,
  apiJourney,
  roleGuardJourney,
  unauthenticatedJourney,
} from './lib/journeys.js';

export const options = {
  vus: 1,
  iterations: 1,
  thresholds: {
    // 302/401/403/404 yang disengaja tetap dihitung, jadi cukup cek checks.
    checks: ['rate>0.95'],
    http_req_duration: ['p(95)<3000'],
  },
  tags: { testid: 'smoke' },
};

export function setup() {
  return buildState({ withAdmin: true, withStudent: true });
}

export function teardown(state) {
  teardownState(state);
}

export default function (state) {
  publicJourney(state);
  apiJourney(state);
  studentJourney(state);
  roleGuardJourney(state);
  adminJourney(state);
  adminPdfJourney(state);

  group('api: login langsung', () => {
    const login = apiLogin(randomStudent());
    // 429 sah terjadi jika smoke dijalankan berulang dalam 1 menit.
    expectStatus(login.res, 'POST /api/login', [200, 429]);

    if (login.res.status === 200) {
      check(login.res, {
        'POST /api/login -> access_token ada': () => !!login.token,
      });
      apiLogout(login.token);
    } else {
      check(login.res, {
        'POST /api/login -> 429 punya pesan': () =>
          !!login.body && login.body.success === false,
      });
    }
  });

  publicExtrasJourney(state);

  // Paling akhir karena menghapus cookie jar.
  unauthenticatedJourney();
}
