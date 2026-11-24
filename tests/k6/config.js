/**
 * Konfigurasi utama test k6 untuk Projek BUBA.
 *
 * Semua nilai bisa dioverride lewat environment variable, contoh:
 *   k6 run -e BASE_URL=http://localhost:8000 -e STUDENT_EMAIL=... tests/k6/smoke.js
 */

const rawBaseUrl = __ENV.BASE_URL || 'http://localhost:8000';

/** URL dasar aplikasi tanpa trailing slash. */
export const BASE_URL = rawBaseUrl.replace(/\/+$/, '');

/** Akun guru/admin (dipakai untuk menguji seluruh halaman /admin). */
export const ADMIN = {
  email: __ENV.ADMIN_EMAIL || 'admin@example.com',
  password: __ENV.ADMIN_PASSWORD || 'admin123',
};

/**
 * Akun siswa default untuk pengujian.
 * Dipilih user yang belum punya reward supaya kategori kuis tidak terkunci.
 */
export const STUDENT = {
  email: __ENV.STUDENT_EMAIL || 'siswa.3206095003@example.test',
  password: __ENV.STUDENT_PASSWORD || 'siswa123',
};

/**
 * Kumpulan akun siswa kelas B (password sama: siswa123).
 * Semua akun di sini berada di kelas yang sama agar data hasil discovery
 * selalu cocok dengan session web yang dipakai VU.
 * Dipakai untuk merotasi akun supaya tidak menabrak rate limit login
 * (5x/menit per email+IP) sekaligus untuk test tulis (write.js).
 */
export const STUDENT_POOL = [
  { email: 'siswa.3206095003@example.test', password: 'siswa123' },
  { email: 'siswa.3206048720@example.test', password: 'siswa123' },
  { email: 'siswa.3206667722@example.test', password: 'siswa123' },
  { email: 'siswa.3209422362@example.test', password: 'siswa123' },
  { email: 'siswa.3205518552@example.test', password: 'siswa123' },
  { email: 'siswa.3216163374@example.test', password: 'siswa123' },
  { email: 'siswa.3216893333@example.test', password: 'siswa123' },
  { email: 'siswa.3209415568@example.test', password: 'siswa123' },
];

/** Pilih satu akun siswa secara acak (untuk menyebar rate limit login). */
export function randomStudent() {
  return STUDENT_POOL[Math.floor(Math.random() * STUDENT_POOL.length)];
}

/** Halaman publik yang selalu diuji. */
export const PUBLIC_PAGES = ['/', '/login', '/register', '/clock'];

/** Aset gambar publik yang dipakai landing & layout. */
export const PUBLIC_IMAGES = [
  '/images/logoBuba.png',
  '/images/icon-materi.png',
  '/images/icon-kuis.png',
  '/images/icon-piala.png',
  '/images/backgroundSplash.png',
  '/images/backgroundAuth.jpg',
  '/images/adminBackground.jpg',
  '/images/logoAdmin.png',
  '/images/navbarDecoration.png',
  '/images/sidebarBackground.png',
  '/favicon.ico',
];

/** Ambil angka dari env dengan fallback. */
export function envInt(name, fallback) {
  const value = Number(__ENV[name]);
  return Number.isFinite(value) && value > 0 ? value : fallback;
}
