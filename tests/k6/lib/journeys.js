/**
 * Kumpulan "journey" yang mensimulasikan aktivitas nyata pengguna.
 * Dipakai ulang oleh smoke.js, load.js, stress.js, spike.js, dan soak.js.
 */

import http from 'k6/http';
import { check, group } from 'k6';
import { get, url, expectStatus, applySession } from './common.js';

/* ------------------------------------------------------------------ */
/*  PUBLIK                                                             */
/* ------------------------------------------------------------------ */

/** Uji aset statis (CSS/JS/gambar) secara paralel. */
export function testAssets(state, key = 'core') {
  const assets = (state.assets && state.assets[key]) || [];
  if (!assets.length) return;

  const responses = http.batch(
    assets.map((path) => ({
      method: 'GET',
      url: url(path),
      params: { tags: { name: `ASET ${path}` } },
    }))
  );

  assets.forEach((path, index) => {
    const res = responses[index];
    check(res, {
      [`ASET ${path} -> 200`]: (r) => r.status === 200,
      [`ASET ${path} -> tidak kosong`]: (r) =>
        typeof r.body === 'string' ? r.body.length > 0 : r.body !== null,
    });
  });
}

/** Halaman publik yang paling sering diakses. */
export function publicJourney(state) {
  group('publik: halaman utama', () => {
    const landing = get('/', { tags: { name: 'GET /' } });
    expectStatus(landing, 'GET /', 200);
    check(landing, {
      'landing -> judul BUBA': (r) =>
        typeof r.body === 'string' && r.body.includes('BUBA'),
    });
  });

  group('publik: halaman auth', () => {
    expectStatus(get('/login', { tags: { name: 'GET /login' } }), 'GET /login', 200);
    expectStatus(
      get('/register', { tags: { name: 'GET /register' } }),
      'GET /register',
      200
    );
  });

  group('publik: halaman jam', () => {
    expectStatus(get('/clock', { tags: { name: 'GET /clock' } }), 'GET /clock', 200);
  });

  group('publik: aset statis inti', () => {
    testAssets(state, 'core');
  });
}

/** Endpoint publik berat / khusus, hanya untuk smoke test. */
export function publicExtrasJourney(state) {
  group('publik: health & utilitas', () => {
    expectStatus(get('/up', { tags: { name: 'GET /up' } }), 'GET /up', 200);

    // APK bisa saja belum di-upload -> 404 tetap respons yang sah.
    const download = get('/download', { tags: { name: 'GET /download' } });
    expectStatus(download, 'GET /download', [200, 404]);
    check(download, {
      'download -> ada isi atau 404 rapi': (r) =>
        r.status === 404 || (r.body && r.body.length > 1000),
    });

    // Hanya tersedia di environment local.
    const mail = get('/mail/preview/verify-email', {
      tags: { name: 'GET /mail/preview' },
    });
    expectStatus(mail, 'GET /mail/preview', [200, 404]);
  });

  group('publik: semua aset gambar', () => {
    testAssets(state, 'all');
  });
}

/* ------------------------------------------------------------------ */
/*  SISWA (WEB)                                                        */
/* ------------------------------------------------------------------ */

export function studentJourney(state) {
  if (!state.studentSession) {
    check(false, { 'sesi siswa tersedia': () => false });
    return;
  }

  const s = state.student || {};
  if (!s.kelasNama || !s.kategoriSlug) {
    check(false, { 'data siswa hasil discovery lengkap': () => false });
    return;
  }

  applySession(state.studentSession);

  group('siswa: splash & konten', () => {
    expectStatus(
      get('/siswa/welcome', { tags: { name: 'GET /siswa/welcome' } }),
      'GET /siswa/welcome',
      200
    );
    expectStatus(
      get('/siswa/konten', { tags: { name: 'GET /siswa/konten' } }),
      'GET /siswa/konten',
      200
    );
  });

  group('siswa: pilih kelas & kategori', () => {
    expectStatus(
      get('/siswa/materi/pilih-kelas', {
        tags: { name: 'GET /siswa/pilih-kelas' },
      }),
      'GET /siswa/materi/pilih-kelas',
      200
    );
    expectStatus(
      get(`/siswa/materi/${s.kelasNama}`, {
        tags: { name: 'GET /siswa/kategori' },
      }),
      'GET /siswa/{kelas}',
      200
    );
  });

  group('siswa: materi', () => {
    expectStatus(
      get(`/siswa/materi/materi-list/${s.kelasNama}/${s.kategoriSlug}`, {
        tags: { name: 'GET /siswa/materi-list' },
      }),
      'GET /siswa/materi-list',
      200
    );

    if (s.materiKode) {
      expectStatus(
        get(
          `/siswa/materi/materi-show/${s.kelasNama}/${s.kategoriSlug}/${s.materiKode}`,
          { tags: { name: 'GET /siswa/materi-show' } }
        ),
        'GET /siswa/materi-show',
        200
      );
    }
  });

  group('siswa: kuis', () => {
    expectStatus(
      get(`/siswa/materi/kuis-list/${s.kelasNama}/${s.kategoriSlug}`, {
        tags: { name: 'GET /siswa/kuis-list' },
      }),
      'GET /siswa/kuis-list',
      200
    );

    if (s.quizKode) {
      const quiz = get(
        `/siswa/materi/kuis-show/${s.kelasNama}/${s.kategoriSlug}/${s.quizKode}`,
        { tags: { name: 'GET /siswa/kuis-show' } }
      );
      // 302 terjadi jika kategori sudah terkunci (bintang >= 3).
      expectStatus(quiz, 'GET /siswa/kuis-show', [200, 302]);

      expectStatus(
        get(
          `/siswa/materi/kuis-hasil/${s.kelasNama}/${s.kategoriSlug}/${s.quizKode}`,
          { tags: { name: 'GET /siswa/kuis-hasil' } }
        ),
        'GET /siswa/kuis-hasil',
        200
      );
    }
  });

  group('siswa: reward & profil', () => {
    expectStatus(
      get('/siswa/reward', { tags: { name: 'GET /siswa/reward' } }),
      'GET /siswa/reward',
      200
    );
    expectStatus(
      get('/profile', { tags: { name: 'GET /profile' } }),
      'GET /profile',
      200
    );
  });
}

/* ------------------------------------------------------------------ */
/*  ADMIN / GURU (WEB)                                                 */
/* ------------------------------------------------------------------ */

export function adminJourney(state) {
  if (!state.adminSession) {
    check(false, { 'sesi admin tersedia': () => false });
    return;
  }

  applySession(state.adminSession);

  const admin = state.admin || {};

  group('admin: dashboard & daftar data', () => {
    const pages = [
      ['/admin/dashboard', 'dashboard'],
      ['/admin/kelas', 'kelas'],
      ['/admin/kategori', 'kategori'],
      ['/admin/materi', 'materi'],
      ['/admin/kuis', 'kuis'],
      ['/admin/siswa', 'siswa'],
      ['/admin/reward', 'reward'],
    ];

    pages.forEach(([path, label]) => {
      const res = get(path, { tags: { name: `GET ${path}` } });
      expectStatus(res, `GET ${path}`, 200);
      check(res, {
        [`halaman ${label} -> tidak kosong`]: (r) =>
          typeof r.body === 'string' && r.body.length > 500,
      });
    });
  });

  group('admin: detail & form edit', () => {
    if (admin.kelasId) {
      expectStatus(
        get(`/admin/kelas/edit/${admin.kelasId}`, {
          tags: { name: 'GET /admin/kelas/edit' },
        }),
        'GET /admin/kelas/edit',
        200
      );
    }

    if (admin.kategoriId) {
      expectStatus(
        get(`/admin/kategori/edit/${admin.kategoriId}`, {
          tags: { name: 'GET /admin/kategori/edit' },
        }),
        'GET /admin/kategori/edit',
        200
      );
    }

    if (admin.materiKode) {
      expectStatus(
        get(`/admin/materi/detail/${admin.materiKode}`, {
          tags: { name: 'GET /admin/materi/detail' },
        }),
        'GET /admin/materi/detail',
        200
      );
      expectStatus(
        get(`/admin/materi/edit/${admin.materiKode}`, {
          tags: { name: 'GET /admin/materi/edit' },
        }),
        'GET /admin/materi/edit',
        200
      );
    }

    if (admin.kuisKode) {
      expectStatus(
        get(`/admin/kuis/detail/${admin.kuisKode}`, {
          tags: { name: 'GET /admin/kuis/detail' },
        }),
        'GET /admin/kuis/detail',
        200
      );
      expectStatus(
        get(`/admin/kuis/edit/${admin.kuisKode}`, {
          tags: { name: 'GET /admin/kuis/edit' },
        }),
        'GET /admin/kuis/edit',
        200
      );
    }

    if (admin.siswaKode) {
      expectStatus(
        get(`/admin/siswa/edit/${admin.siswaKode}`, {
          tags: { name: 'GET /admin/siswa/edit' },
        }),
        'GET /admin/siswa/edit',
        200
      );
    }
  });

  group('admin: form tambah', () => {
    const forms = [
      '/admin/kelas/tambah',
      '/admin/kategori/tambah',
      '/admin/materi/tambah',
      '/admin/kuis/tambah',
      '/admin/siswa/tambah',
    ];
    forms.forEach((path) => {
      expectStatus(get(path, { tags: { name: `GET ${path}` } }), `GET ${path}`, 200);
    });
  });

  group('admin: profil', () => {
    expectStatus(
      get('/profile', { tags: { name: 'GET /profile (admin)' } }),
      'GET /profile (admin)',
      200
    );
  });
}

/** Unduh PDF reward (berat, hanya untuk smoke test). */
export function adminPdfJourney(state) {
  if (!state.adminSession) return;
  applySession(state.adminSession);

  group('admin: unduh PDF', () => {
    const res = get('/admin/reward/pdf', {
      tags: { name: 'GET /admin/reward/pdf' },
    });
    expectStatus(res, 'GET /admin/reward/pdf', 200);
    check(res, {
      'PDF -> content-type pdf': (r) =>
        String(r.headers['Content-Type'] || r.headers['content-type'] || '')
          .toLowerCase()
          .includes('pdf'),
    });
  });
}

/* ------------------------------------------------------------------ */
/*  API (SANCTUM)                                                      */
/* ------------------------------------------------------------------ */

export function apiJourney(state) {
  if (!state.apiHeaders) {
    check(false, { 'token API tersedia': () => false });
    return;
  }

  const headers = state.apiHeaders;
  const s = state.student || {};

  group('api: profil & status', () => {
    expectStatus(
      get('/api/me', { headers, tags: { name: 'GET /api/me' } }),
      'GET /api/me',
      200
    );
    expectStatus(
      get('/api/email/status', {
        headers,
        tags: { name: 'GET /api/email/status' },
      }),
      'GET /api/email/status',
      200
    );
  });

  group('api: kelas & kategori', () => {
    expectStatus(
      get('/api/siswa/kelas', {
        headers,
        tags: { name: 'GET /api/siswa/kelas' },
      }),
      'GET /api/siswa/kelas',
      200
    );

    if (s.kelasId) {
      expectStatus(
        get(`/api/siswa/kategori/${s.kelasId}`, {
          headers,
          tags: { name: 'GET /api/siswa/kategori' },
        }),
        'GET /api/siswa/kategori',
        200
      );
    }
  });

  group('api: materi', () => {
    if (!s.kelasId || !s.kategoriId) return;

    expectStatus(
      get(
        `/api/siswa/materi?kelas_id=${s.kelasId}&kategori_id=${s.kategoriId}`,
        { headers, tags: { name: 'GET /api/siswa/materi' } }
      ),
      'GET /api/siswa/materi',
      200
    );

    if (s.materiKode) {
      expectStatus(
        get(`/api/siswa/materi/${s.materiKode}`, {
          headers,
          tags: { name: 'GET /api/siswa/materi/{kode}' },
        }),
        'GET /api/siswa/materi/{kode}',
        200
      );
    }
  });

  group('api: kuis & hasil', () => {
    if (s.kelasId && s.kategoriId) {
      expectStatus(
        get(
          `/api/siswa/kuis?kelas_id=${s.kelasId}&kategori_id=${s.kategoriId}`,
          { headers, tags: { name: 'GET /api/siswa/kuis' } }
        ),
        'GET /api/siswa/kuis',
        200
      );
    }

    expectStatus(
      get('/api/siswa/hasil-kuis', {
        headers,
        tags: { name: 'GET /api/siswa/hasil-kuis' },
      }),
      'GET /api/siswa/hasil-kuis',
      200
    );
  });
}

/* ------------------------------------------------------------------ */
/*  OTORISASI / KEAMANAN DASAR                                         */
/* ------------------------------------------------------------------ */

/** Endpoint yang seharusnya menolak akses tanpa login. */
export function unauthenticatedJourney() {
  group('keamanan: akses tanpa login', () => {
    // Cookie jar bisa saja masih berisi sesi; pastikan bersih dulu.
    http.cookieJar().clear(url('/'));

    // GET halaman admin -> redirect ke login.
    expectStatus(
      get('/admin/dashboard', {
        redirects: 0,
        tags: { name: 'GET /admin/dashboard (guest)' },
      }),
      'guest /admin/dashboard',
      302
    );

    // API tanpa Bearer token -> 401.
    expectStatus(
      get('/api/me', {
        headers: { Accept: 'application/json' },
        tags: { name: 'GET /api/me (guest)' },
      }),
      'guest /api/me',
      401
    );
  });
}

/** Cek endpoint yang butuh role (siswa tidak boleh masuk admin). */
export function roleGuardJourney(state) {
  if (!state.studentSession) return;
  applySession(state.studentSession);

  group('keamanan: siswa tidak boleh akses admin', () => {
    const res = get('/admin/dashboard', {
      redirects: 0,
      tags: { name: 'GET /admin/dashboard (siswa)' },
    });

    // Middleware CheckRole mengalihkan siswa ke splash, bukan 403.
    expectStatus(res, 'siswa /admin/dashboard', 302);
    check(res, {
      'siswa /admin/dashboard -> diarahkan ke /siswa/welcome': (r) => {
        const location = r.headers.Location || r.headers.location || '';
        return location.includes('/siswa/welcome');
      },
    });
  });
}
