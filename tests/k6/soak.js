/**
 * SOAK / ENDURANCE TEST
 * Beban sedang dalam waktu lama untuk mendeteksi kebocoran memori,
 * penumpukan session, dan penurunan performa seiring waktu.
 *
 * Jalankan:
 *   k6 run -e BASE_URL=http://localhost:8000 tests/k6/soak.js
 *
 * Atur durasi & beban:
 *   SOAK_DURATION=30m SOAK_VUS=10 k6 run tests/k6/soak.js
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

const DURATION = __ENV.SOAK_DURATION || '10m';
const BASE_VUS = envInt('SOAK_VUS', 8);

export const options = {
  scenarios: {
    soak_public: {
      executor: 'constant-vus',
      exec: 'publicScenario',
      vus: Math.max(1, Math.round(BASE_VUS / 2)),
      duration: DURATION,
      gracefulStop: '15s',
    },
    soak_student: {
      executor: 'constant-vus',
      exec: 'studentScenario',
      vus: Math.max(1, Math.round(BASE_VUS / 3)),
      duration: DURATION,
      gracefulStop: '15s',
    },
    soak_admin: {
      executor: 'constant-vus',
      exec: 'adminScenario',
      vus: 1,
      duration: DURATION,
      gracefulStop: '15s',
    },
    soak_api: {
      executor: 'constant-vus',
      exec: 'apiScenario',
      vus: Math.max(1, Math.round(BASE_VUS / 2)),
      duration: DURATION,
      gracefulStop: '15s',
    },
  },
  thresholds: {
    checks: ['rate>0.98'],
    http_req_failed: ['rate<0.02'],
    'http_req_duration{scenario:soak_api}': ['p(95)<1500', 'p(99)<3000'],
    'http_req_duration{scenario:soak_public}': ['p(95)<3500'],
    'http_req_duration{scenario:soak_student}': ['p(95)<3500'],
    'http_req_duration{scenario:soak_admin}': ['p(95)<3500'],
  },
  summaryTrendStats: ['avg', 'min', 'med', 'max', 'p(90)', 'p(95)', 'p(99)'],
  tags: { testid: 'soak' },
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
