/**
 * LOAD TEST (beban normal)
 * Mensimulasikan pengunjung publik, siswa, guru/admin, dan klien API
 * secara bersamaan selama ±2 menit.
 *
 * Jalankan:
 *   k6 run -e BASE_URL=http://localhost:8000 tests/k6/load.js
 *
 * Atur beban lewat env, contoh:
 *   PUBLIC_VUS=10 STUDENT_VUS=8 ADMIN_VUS=3 API_VUS=20 k6 run tests/k6/load.js
 */

import { sleep } from 'k6';
import { envInt } from './config.js';
import { buildState, teardownState } from './lib/state.js';
import {
  publicJourney,
  studentJourney,
  adminJourney,
  apiJourney,
} from './lib/journeys.js';

const PUBLIC_VUS = envInt('PUBLIC_VUS', 6);
const STUDENT_VUS = envInt('STUDENT_VUS', 4);
const ADMIN_VUS = envInt('ADMIN_VUS', 2);
const API_VUS = envInt('API_VUS', 8);

const WEB_P95 = __ENV.WEB_P95 || '3000';
const WEB_P99 = __ENV.WEB_P99 || '6000';
const API_P95 = __ENV.API_P95 || '1200';
const API_P99 = __ENV.API_P99 || '2500';
const MAX_FAIL_RATE = __ENV.MAX_FAIL_RATE || '0.02';

function stages(target) {
  const peak = Math.max(1, target);
  return [
    { duration: '30s', target: Math.max(1, Math.round(peak * 0.4)) },
    { duration: '60s', target: peak },
    { duration: '30s', target: 0 },
  ];
}

export const options = {
  scenarios: {
    public_browse: {
      executor: 'ramping-vus',
      exec: 'publicScenario',
      startVUs: 1,
      stages: stages(PUBLIC_VUS),
      gracefulRampDown: '15s',
    },
    student_web: {
      executor: 'ramping-vus',
      exec: 'studentScenario',
      startVUs: 1,
      stages: stages(STUDENT_VUS),
      gracefulRampDown: '15s',
    },
    admin_web: {
      executor: 'ramping-vus',
      exec: 'adminScenario',
      startVUs: 1,
      stages: stages(ADMIN_VUS),
      gracefulRampDown: '15s',
    },
    api_read: {
      executor: 'ramping-vus',
      exec: 'apiScenario',
      startVUs: 1,
      stages: stages(API_VUS),
      gracefulRampDown: '15s',
    },
  },
  thresholds: {
    checks: ['rate>0.98'],

    [`http_req_failed{scenario:public_browse}`]: [`rate<${MAX_FAIL_RATE}`],
    [`http_req_failed{scenario:student_web}`]: [`rate<${MAX_FAIL_RATE}`],
    [`http_req_failed{scenario:admin_web}`]: [`rate<${MAX_FAIL_RATE}`],
    [`http_req_failed{scenario:api_read}`]: [`rate<${MAX_FAIL_RATE}`],

    [`http_req_duration{scenario:public_browse}`]: [
      `p(95)<${WEB_P95}`,
      `p(99)<${WEB_P99}`,
    ],
    [`http_req_duration{scenario:student_web}`]: [
      `p(95)<${WEB_P95}`,
      `p(99)<${WEB_P99}`,
    ],
    [`http_req_duration{scenario:admin_web}`]: [
      `p(95)<${WEB_P95}`,
      `p(99)<${WEB_P99}`,
    ],
    [`http_req_duration{scenario:api_read}`]: [
      `p(95)<${API_P95}`,
      `p(99)<${API_P99}`,
    ],
  },
  summaryTrendStats: ['avg', 'min', 'med', 'max', 'p(90)', 'p(95)', 'p(99)'],
  tags: { testid: 'load' },
};

export function setup() {
  return buildState({ withAdmin: true, withStudent: true });
}

export function teardown(state) {
  teardownState(state);
}

export function publicScenario(state) {
  publicJourney(state);
  sleep(1 + Math.random() * 2);
}

export function studentScenario(state) {
  studentJourney(state);
  sleep(1 + Math.random() * 2);
}

export function adminScenario(state) {
  adminJourney(state);
  sleep(1 + Math.random() * 2);
}

export function apiScenario(state) {
  apiJourney(state);
  sleep(0.5 + Math.random());
}
