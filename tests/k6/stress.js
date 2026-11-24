/**
 * STRESS TEST
 * Menaikkan beban bertahap sampai jauh di atas kapasitas normal
 * untuk menemukan titik jenuh (breaking point).
 *
 * Jalankan:
 *   k6 run -e BASE_URL=http://localhost:8000 tests/k6/stress.js
 *
 * Atur puncak beban:
 *   STRESS_PEAK=100 k6 run tests/k6/stress.js
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

const PEAK = envInt('STRESS_PEAK', 80);

function stages() {
  const peak = PEAK;
  return [
    { duration: '1m', target: Math.round(peak * 0.25) },
    { duration: '1m', target: Math.round(peak * 0.5) },
    { duration: '1m', target: Math.round(peak * 0.75) },
    { duration: '1m', target: peak },
    { duration: '1m', target: peak },
    { duration: '30s', target: 0 },
  ];
}

export const options = {
  scenarios: {
    stress_web: {
      executor: 'ramping-vus',
      exec: 'webScenario',
      startVUs: 1,
      stages: stages(),
      gracefulRampDown: '20s',
    },
    stress_api: {
      executor: 'ramping-vus',
      exec: 'apiScenario',
      startVUs: 1,
      stages: stages(),
      gracefulRampDown: '20s',
    },
  },
  thresholds: {
    // Tujuan stress test bukan lolos threshold, tapi melihat kapan mulai gagal.
    checks: ['rate>0.90'],
    http_req_failed: ['rate<0.10'],
  },
  summaryTrendStats: ['avg', 'min', 'med', 'max', 'p(90)', 'p(95)', 'p(99)'],
  tags: { testid: 'stress' },
};

export function setup() {
  return buildState({ withAdmin: true, withStudent: true });
}

export function teardown(state) {
  teardownState(state);
}

export function webScenario(state) {
  // Bergantian antara halaman publik, siswa, dan admin.
  const pick = Math.floor(Math.random() * 3);
  if (pick === 0) publicJourney(state);
  else if (pick === 1) studentJourney(state);
  else adminJourney(state);

  sleep(0.5 + Math.random());
}

export function apiScenario(state) {
  apiJourney(state);
  sleep(0.3 + Math.random() * 0.7);
}
