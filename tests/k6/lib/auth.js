/**
 * Login untuk dua jenis autentikasi:
 *  - Web  : form login Laravel (session cookie + CSRF)
 *  - API  : Sanctum personal access token (Bearer)
 */

import { check } from 'k6';
import {
  url,
  get,
  post,
  jsonRequest,
  extractCsrf,
  captureSession,
  clearSession,
  safeJson,
} from './common.js';

/**
 * Login melalui form web Laravel.
 * Mengembalikan session cookie yang bisa dipakai ulang oleh VU lain.
 */
export function webLogin(user, redirectTarget) {
  clearSession();

  const page = get('/login', { tags: { name: 'GET /login (auth)' } });
  const csrf = extractCsrf(page.body);

  const res = post(
    '/login',
    {
      _token: csrf || '',
      email: user.email,
      password: user.password,
    },
    {
      redirects: 0,
      tags: { name: 'POST /login (auth)' },
    }
  );

  const session = captureSession(res, page);
  const location = res.headers.Location || res.headers.location || '';

  const ok = check(res, {
    'login web -> 302': (r) => r.status === 302,
    'login web -> dapat session cookie': () => !!session.sessionValue,
    'login web -> redirect sesuai role': () =>
      !!redirectTarget && location.includes(redirectTarget),
  });

  return { page, res, csrf, session, location, ok };
}

/** Login API Sanctum. */
export function apiLogin(user) {
  const res = jsonRequest('POST', '/api/login', {
    email: user.email,
    password: user.password,
  });

  const body = safeJson(res) || {};

  check(res, {
    'login api -> 200': (r) => r.status === 200,
    'login api -> dapat access_token': () => !!body.access_token,
  });

  return { res, body, token: body.access_token || null };
}

/** Header Authorization untuk endpoint API. */
export function apiHeaders(token) {
  return {
    Authorization: `Bearer ${token}`,
    Accept: 'application/json',
  };
}

/** Logout API (dipakai teardown agar token tidak menumpuk di database). */
export function apiLogout(token) {
  if (!token) return null;
  return post('/api/logout', null, {
    headers: apiHeaders(token),
    tags: { name: 'POST /api/logout' },
  });
}
