/**
 * SPIKE TEST
 * Lonjakan trafik mendadak (misal saat jam belajar dimulai) lalu kembali normal.
 *
 * Jalankan:
 *   k6 run -e BASE_URL=http://localhost:8000 tests/k6/spike.js
 *
 * Atur besar lonjakan:
 *   SPIKE_VUS=100 k6 run tests/k6/spike.js
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

const SPIKE_VUS = envInt('SPIKE_VUS', 60);
const SPIKE_WEB_VUS = Math.max(2, Math.round(SPIKE_VUS / 3));

export const options = {
  scenarios: {
    spike_api: {
      executor: 'ramping-vus',
      exec: 'apiScenario',
      startVUs: 1,
      stages: [
        { duration: '10s', target: SPIKE_VUS },
        { duration: '1m', target: SPIKE_VUS },
        { duration: '10s', target: 0 },
      ],
      gracefulRampDown: '10s',
    },
    spike_web: {
      executor: 'ramping-vus',
      exec: 'webScenario',
      startVUs: 1,
      stages: [
        { duration: '10s', target: SPIKE_WEB_VUS },
        { duration: '1m', target: SPIKE_WEB_VUS },
        { duration: '10s', target: 0 },
      ],
      gracefulRampDown: '10s',
    },
  },
  thresholds: {
    checks: ['rate>0.95'],
    http_req_failed: ['rate<0.05'],
  },
  summaryTrendStats: ['avg', 'min', 'med', 'max', 'p(90)', 'p(95)', 'p(99)'],
  tags: { testid: 'spike' },
};

export function setup() {
  return buildState({ withAdmin: true, withStudent: true });
}

export function teardown(state) {
  teardownState(state);
}

export function webScenario(state) {
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
