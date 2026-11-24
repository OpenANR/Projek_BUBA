/**
 * Discovery data saat setup():
 *  - aset hasil build Vite (CSS/JS)
 *  - ID/kode data nyata dari API (kelas, kategori, materi, kuis)
 *  - ID/kode data admin dengan membaca link halaman admin
 *
 * Semua hasil dikembalikan sebagai objek biasa agar bisa dikirim ke VU.
 */

import { BASE_URL, PUBLIC_IMAGES } from '../config.js';
import { url, get, safeJson, cookieValue } from './common.js';
import { apiHeaders } from './auth.js';

function firstMatch(html, regex) {
  if (!html) return null;
  const match = html.match(regex);
  return match ? match[1] : null;
}

/** Ambil URL aset dari manifest Vite. */
export function discoverAssets() {
  const manifestRes = get('/build/manifest.json', {
    tags: { name: 'SETUP /build/manifest.json' },
  });
  const manifest = safeJson(manifestRes);

  const css = manifest && manifest['resources/css/app.css'];
  const js = manifest && manifest['resources/js/app.js'];

  const core = ['/build/manifest.json'];
  if (css && css.file) core.push(`/build/${css.file}`);
  if (js && js.file) core.push(`/build/${js.file}`);
  core.push('/images/logoBuba.png', '/favicon.ico');

  const all = core.concat(
    PUBLIC_IMAGES.filter((image) => !core.includes(image))
  );

  return {
    manifestUrl: '/build/manifest.json',
    css: css && css.file ? `/build/${css.file}` : null,
    js: js && js.file ? `/build/${js.file}` : null,
    core,
    all: Array.from(new Set(all)),
  };
}

/**
 * Ambil ID/kode data admin dengan membaca halaman daftar.
 * Diasumsikan cookie admin sudah aktif di cookie jar.
 */
export function discoverAdminData() {
  const kelasPage = get('/admin/kelas', { tags: { name: 'SETUP /admin/kelas' } });
  const kategoriPage = get('/admin/kategori', {
    tags: { name: 'SETUP /admin/kategori' },
  });
  const materiPage = get('/admin/materi', {
    tags: { name: 'SETUP /admin/materi' },
  });
  const kuisPage = get('/admin/kuis', { tags: { name: 'SETUP /admin/kuis' } });
  const siswaPage = get('/admin/siswa', { tags: { name: 'SETUP /admin/siswa' } });

  return {
    kelasId: firstMatch(kelasPage.body, /\/admin\/kelas\/edit\/(\d+)/),
    kategoriId: firstMatch(kategoriPage.body, /\/admin\/kategori\/edit\/(\d+)/),
    materiKode: firstMatch(materiPage.body, /\/admin\/materi\/edit\/([A-Za-z0-9_-]+)/),
    kuisKode: firstMatch(kuisPage.body, /\/admin\/kuis\/edit\/([A-Za-z0-9_-]+)/),
    siswaKode: firstMatch(siswaPage.body, /\/admin\/siswa\/edit\/([A-Za-z0-9_-]+)/),
    status: {
      kelas: kelasPage.status,
      kategori: kategoriPage.status,
      materi: materiPage.status,
      kuis: kuisPage.status,
      siswa: siswaPage.status,
    },
  };
}

/**
 * Ambil data siswa (kelas, kategori, materi, kuis) lewat API.
 * Hasil dipakai untuk membangun URL halaman web siswa.
 */
export function discoverStudentData(token) {
  const headers = apiHeaders(token);
  const result = {
    kelasId: null,
    kelasNama: null,
    kategoriId: null,
    kategoriSlug: null,
    kategoriNama: null,
    materiKode: null,
    materiNama: null,
    quizKode: null,
    quizId: null,
    quizCount: 0,
    kategoriList: [],
  };

  if (!token) return result;

  const kelasRes = get('/api/siswa/kelas', {
    headers,
    tags: { name: 'SETUP /api/siswa/kelas' },
  });
  const kelasBody = safeJson(kelasRes);
  const kelas = kelasBody && kelasBody.kelas && kelasBody.kelas[0];
  if (!kelas) return result;

  result.kelasId = kelas.id;
  result.kelasNama = String(kelas.nama_kelas || '').trim();

  const kategoriRes = get(`/api/siswa/kategori/${kelas.id}`, {
    headers,
    tags: { name: 'SETUP /api/siswa/kategori' },
  });
  const kategoriBody = safeJson(kategoriRes);
  const kategoris = (kategoriBody && kategoriBody.kategori) || [];
  result.kategoriList = kategoris.map((item) => ({
    id: item.id,
    slug: item.slug,
    nama: item.nama_kategori,
  }));

  // Cari kategori pertama yang punya soal kuis.
  let kategoriKuis = null;
  let soalPertama = null;

  for (const kategori of kategoris) {
    const quizRes = get(
      `/api/siswa/kuis?kelas_id=${kelas.id}&kategori_id=${kategori.id}`,
      { headers, tags: { name: 'SETUP /api/siswa/kuis' } }
    );
    const quizBody = safeJson(quizRes);
    const daftar = (quizBody && quizBody.data) || [];

    if (daftar.length > 0) {
      kategoriKuis = kategori;
      soalPertama = daftar[0];
      result.quizCount = daftar.length;
      break;
    }
  }

  const kategoriMateri = kategoriKuis || kategoris[0] || null;

  if (kategoriMateri) {
    result.kategoriId = kategoriMateri.id;
    result.kategoriSlug = kategoriMateri.slug;
    result.kategoriNama = kategoriMateri.nama_kategori;

    const materiRes = get(
      `/api/siswa/materi?kelas_id=${kelas.id}&kategori_id=${kategoriMateri.id}`,
      { headers, tags: { name: 'SETUP /api/siswa/materi' } }
    );
    const materiBody = safeJson(materiRes);
    const materi =
      (materiBody && materiBody.data && materiBody.data[0]) || null;

    if (materi) {
      result.materiKode = materi.kode_materi;
      result.materiNama = materi.nama_materi;
    }
  }

  if (soalPertama) {
    result.quizKode = soalPertama.kode_kuis;
    result.quizId = soalPertama.id;
  }

  return result;
}

/** Data fallback jika discovery API gagal (misal rate limit). */
export function fallbackStudentData() {
  return {
    kelasId: 2,
    kelasNama: 'B',
    kategoriId: 12,
    kategoriSlug: 'bentuk-pola',
    kategoriNama: 'Bentuk & Pola',
    materiKode: null,
    materiNama: null,
    quizKode: __ENV.QUIZ_KODE || 'KUIS-83G9',
    quizId: null,
    quizCount: 1,
    kategoriList: [],
  };
}

/** Cek apakah cookie session yang tersimpan masih valid. */
export function sessionIsValid(session) {
  return !!(session && session.sessionValue);
}

/** Info tambahan yang berguna saat debugging. */
export function describeState(state) {
  return {
    baseUrl: BASE_URL,
    assets: state.assets ? state.assets.core.length : 0,
    student: state.student || null,
    admin: state.admin || null,
  };
}

/** Ambil cookie dari response (dipakai untuk debug). */
export { cookieValue };
