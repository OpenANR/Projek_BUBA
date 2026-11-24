/**
 * Helper umum: request ber-tag, validasi response, parsing CSRF,
 * dan pengelolaan cookie/session Laravel.
 */

import http from 'k6/http';
import { check } from 'k6';
import { BASE_URL } from '../config.js';

/** Gabungkan BASE_URL dengan path. */
export function url(path) {
  const clean = path.startsWith('/') ? path : `/${path}`;
  return `${BASE_URL}${clean}`;
}

function buildParams(method, path, params) {
  const { tags = {}, ...rest } = params || {};
  return {
    ...rest,
    tags: {
      name: `${method} ${path}`,
      ...tags,
    },
  };
}

/** Request generik dengan tag `name` yang stabil di laporan k6. */
export function request(method, path, body, params = {}) {
  return http.request(method, url(path), body, buildParams(method, path, params));
}

export function get(path, params = {}) {
  return request('GET', path, null, params);
}

export function post(path, body, params = {}) {
  return request('POST', path, body, params);
}

/** Request JSON dengan header yang tepat. */
export function jsonRequest(method, path, payload, params = {}) {
  return request(method, path, JSON.stringify(payload), {
    ...params,
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
      ...(params.headers || {}),
    },
  });
}

/**
 * Cek status response.
 * @param {object} res response k6
 * @param {string} label nama check
 * @param {number|number[]} expected status yang dianggap sukses
 */
export function expectStatus(res, label, expected = 200) {
  const allowed = Array.isArray(expected) ? expected : [expected];
  return check(res, {
    [`${label} -> ${allowed.join('|')}`]: (r) => allowed.includes(r.status),
  });
}

/** Cek response JSON dengan field `success === true`. */
export function expectJsonSuccess(res, label) {
  let body = null;
  try {
    body = res.json();
  } catch (e) {
    body = null;
  }

  const statusOk = expectStatus(res, label, 200);
  const bodyOk = check(res, {
    [`${label} -> success=true`]: () => !!body && body.success === true,
  });

  return statusOk && bodyOk;
}

/** Cek body mengandung teks tertentu (misal judul halaman). */
export function expectBodyContains(res, label, text) {
  return check(res, {
    [`${label} -> mengandung "${text}"`]: (r) =>
      typeof r.body === 'string' && r.body.includes(text),
  });
}

/** Ambil token CSRF dari HTML (input hidden atau meta tag). */
export function extractCsrf(html) {
  if (!html) return null;

  const input =
    html.match(/name="_token"[^>]*value="([^"]+)"/) ||
    html.match(/value="([^"]+)"[^>]*name="_token"/);

  if (input) return input[1];

  const meta = html.match(/name="csrf-token"[^>]*content="([^"]+)"/);
  return meta ? meta[1] : null;
}

/** Ambil value input hidden berdasarkan atribut id. */
export function extractHiddenById(html, id) {
  if (!html) return null;
  const match = html.match(new RegExp(`id="${id}"[^>]*value="([^"]+)"`));
  return match ? match[1] : null;
}

/** Ambil nilai cookie dari response k6. */
export function cookieValue(res, name) {
  if (!res || !res.cookies || !name) return null;
  const list = res.cookies[name];
  return list && list.length ? list[0].value : null;
}

/**
 * Cari nama cookie session Laravel.
 * Nama default mengikuti APP_NAME (misal "projek-buba-session"),
 * jadi tidak boleh di-hardcode "laravel_session".
 * Bisa dioverride lewat env SESSION_COOKIE.
 */
export function findSessionCookieName(res, fallbackRes) {
  if (__ENV.SESSION_COOKIE) return __ENV.SESSION_COOKIE;

  const merged = {
    ...((fallbackRes && fallbackRes.cookies) || {}),
    ...((res && res.cookies) || {}),
  };

  return (
    Object.keys(merged).find(
      (name) =>
        /session$/i.test(name) && name.toLowerCase() !== 'xsrf-token'
    ) || null
  );
}

/** Simpan cookie session Laravel dari response (dengan fallback). */
export function captureSession(res, fallbackRes) {
  const sessionName = findSessionCookieName(res, fallbackRes);

  return {
    sessionName,
    sessionValue:
      cookieValue(res, sessionName) || cookieValue(fallbackRes, sessionName),
    xsrfToken:
      cookieValue(res, 'XSRF-TOKEN') || cookieValue(fallbackRes, 'XSRF-TOKEN'),
  };
}

/** Terapkan cookie session ke cookie jar VU saat ini. */
export function applySession(session) {
  const jar = http.cookieJar();
  jar.clear(BASE_URL);

  if (!session) return;

  if (session.sessionName && session.sessionValue) {
    jar.set(BASE_URL, session.sessionName, session.sessionValue);
  }
  if (session.xsrfToken) {
    jar.set(BASE_URL, 'XSRF-TOKEN', session.xsrfToken);
  }
}

/** Bersihkan cookie jar VU. */
export function clearSession() {
  http.cookieJar().clear(BASE_URL);
}

/** Ambil title halaman dari HTML. */
export function pageTitle(html) {
  if (!html) return '';
  const match = html.match(/<title[^>]*>([^<]*)<\/title>/i);
  return match ? match[1].trim() : '';
}

/** Parse JSON dengan aman. */
export function safeJson(res) {
  try {
    return res.json();
  } catch (e) {
    return null;
  }
}
