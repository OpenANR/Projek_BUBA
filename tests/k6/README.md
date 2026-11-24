# Performance Test k6 — Projek BUBA

Suite pengujian performa untuk aplikasi **Projek BUBA** (Laravel 12) menggunakan
[Grafana k6](https://grafana.com/docs/k6/latest/). Suite ini menguji **seluruh
lapisan aplikasi**:

- halaman publik (landing, login, register, jam, download APK, aset statis),
- area siswa (splash, konten, pilih kelas, kategori, materi, kuis, reward),
- area admin/guru (dashboard, CRUD list/detail/form, PDF reward, profil),
- REST API Sanctum (profil, kelas, kategori, materi, kuis, hasil),
- alur tulis opsional (login, submit kuis, logout),
- pengecekan keamanan dasar (akses tanpa login & salah role).

---

## 1. Prasyarat

1. **k6** terpasang.

   ```bash
   k6 version
   # k6 v2.4.0 ...
   ```

   Jika belum:

   ```bash
   # Fedora/RHEL
   sudo dnf install k6
   # atau lihat: https://grafana.com/docs/k6/latest/set-up/install-k6/
   ```

2. Aplikasi berjalan dan database sudah di-seed.

   ```bash
   php artisan migrate:fresh --seed
   php artisan serve --host=0.0.0.0 --port=8000
   ```

   Default target test: **http://localhost:8000**. Jika memakai Apache/nginx,
   override lewat `BASE_URL`.

3. Akun seed yang dipakai:

   | Peran | Email | Password |
   |---|---|---|
   | Admin/guru | `admin@example.com` | `admin123` |
   | Siswa | `siswa.3206095003@example.test` | `siswa123` |

   Suite juga memakai 8 akun siswa kelas B lain (lihat `config.js`) agar rate
   limit login tidak cepat tercapai.

> **Penting:** `php artisan serve` hanya memakai 1 worker PHP. Hasil load test
> akan mentok di kapasitas 1 proses. Untuk hasil representatif, gunakan
> Apache/nginx + PHP-FPM, atau jalankan minimal:
> `PHP_CLI_SERVER_WORKERS=4 php artisan serve`.

---

## 2. Struktur file

```
tests/k6/
├── config.js          # BASE_URL, akun, daftar halaman, env helper
├── smoke.js           # 1 VU, 1 iterasi, semua endpoint (cepat)
├── load.js            # beban normal: publik + siswa + admin + API
├── stress.js          # naik bertahap mencari breaking point
├── spike.js           # lonjakan trafik mendadak
├── soak.js            # beban sedang, durasi lama
├── write.js           # alur tulis (opsional, merusak data)
├── run.sh             # runner praktis
└── lib/
    ├── common.js      # request, check, CSRF, cookie/session
    ├── auth.js        # login web (session) & API (Sanctum)
    ├── discovery.js   # ambil aset & data nyata dari API/halaman admin
    ├── state.js       # setup/teardown + state global
    └── journeys.js    # skenario publik, siswa, admin, API, keamanan
```

Jalankan semua perintah dari **root proyek**:

```bash
./tests/k6/run.sh smoke
```

Atau langsung dengan k6:

```bash
k6 run -e BASE_URL=http://localhost:8000 tests/k6/smoke.js
```

---

## 3. Profil pengujian

| Profil | Tujuan | Durasi default | Beban default |
|---|---|---|---|
| `smoke` | Memastikan semua halaman/endpoint hidup & tidak error | ±5 detik | 1 VU, 1 iterasi |
| `load` | Performa pada beban normal | ±2 menit | 6 publik + 4 siswa + 2 admin + 8 API |
| `stress` | Mencari titik jenuh | ±5,5 menit | naik sampai 80 VU per skenario |
| `spike` | Ketahanan saat lonjakan mendadak | ±1,5 menit | 60 API + 20 web |
| `soak` | Deteksi memory leak / degradasi | 10 menit | 12 VU total |
| `write` | Alur tulis (login, submit kuis, logout) | ±5 detik | 3 VU, 1 iterasi/VU |

### Contoh perintah

```bash
# 1. Cek cepat
./tests/k6/run.sh smoke

# 2. Load test standar
./tests/k6/run.sh load

# 3. Load test dengan beban lebih besar
PUBLIC_VUS=10 STUDENT_VUS=8 ADMIN_VUS=3 API_VUS=20 ./tests/k6/run.sh load

# 4. Stress sampai 120 VU
STRESS_PEAK=120 ./tests/k6/run.sh stress

# 5. Spike 100 VU
SPIKE_VUS=100 ./tests/k6/run.sh spike

# 6. Soak 30 menit
SOAK_DURATION=30m SOAK_VUS=10 ./tests/k6/run.sh soak

# 7. Test tulis (hati-hati!)
./tests/k6/run.sh write

# 8. Simpan hasil JSON
mkdir -p reports
./tests/k6/run.sh load --out json=reports/load.json

# 9. Ringkasan JSON (mudah diolah CI)
./tests/k6/run.sh smoke --summary-export=reports/smoke-summary.json
```

---

## 4. Cakupan pengujian

### 4.1 Publik

| Method | Path | Keterangan |
|---|---|---|
| GET | `/` | Landing page, cek judul BUBA |
| GET | `/login` | Halaman login |
| GET | `/register` | Halaman registrasi |
| GET | `/clock` | Halaman jam |
| GET | `/up` | Health check Laravel |
| GET | `/download` | Unduh APK (5 MB, hanya smoke) |
| GET | `/mail/preview/verify-email` | Pratinjau email (local only) |
| GET | `/build/manifest.json`, CSS, JS | Hasil build Vite |
| GET | 11 gambar publik | Logo, ikon, background, favicon |

### 4.2 Siswa (web)

| Method | Path |
|---|---|
| GET | `/siswa/welcome` (splash) |
| GET | `/siswa/konten` |
| GET | `/siswa/materi/pilih-kelas` |
| GET | `/siswa/materi/{kelas}` |
| GET | `/siswa/materi/materi-list/{kelas}/{kategori}` |
| GET | `/siswa/materi/materi-show/{kelas}/{kategori}/{materi}` |
| GET | `/siswa/materi/kuis-list/{kelas}/{kategori}` |
| GET | `/siswa/materi/kuis-show/{kelas}/{kategori}/{kuis}` |
| GET | `/siswa/materi/kuis-hasil/{kelas}/{kategori}/{kuis}` |
| GET | `/siswa/reward` |
| GET | `/profile` |

### 4.3 Admin / guru (web)

| Method | Path |
|---|---|
| GET | `/admin/dashboard` |
| GET | `/admin/kelas`, `/admin/kategori`, `/admin/materi`, `/admin/kuis`, `/admin/siswa`, `/admin/reward` |
| GET | `/admin/{kelas,kategori,materi,kuis,siswa}/edit/{id}` |
| GET | `/admin/materi/detail/{kode}`, `/admin/kuis/detail/{kode}` |
| GET | `/admin/{kelas,kategori,materi,kuis,siswa}/tambah` |
| GET | `/admin/reward/pdf` (hanya smoke) |
| GET | `/profile` |

### 4.4 API (Sanctum)

| Method | Path |
|---|---|
| POST | `/api/login` |
| GET | `/api/me` |
| GET | `/api/email/status` |
| GET | `/api/siswa/kelas` |
| GET | `/api/siswa/kategori/{kelas_id}` |
| GET | `/api/siswa/materi?kelas_id=&kategori_id=` |
| GET | `/api/siswa/materi/{kode_materi}` |
| GET | `/api/siswa/kuis?kelas_id=&kategori_id=` |
| GET | `/api/siswa/hasil-kuis` |
| POST | `/api/logout` (teardown) |
| POST | `/api/siswa/kuis/submit` (write.js) |

### 4.5 Keamanan dasar

- Guest membuka `/admin/dashboard` → `302` ke login.
- Guest memanggil `/api/me` → `401`.
- Siswa membuka `/admin/dashboard` → `302` ke `/siswa/welcome`.

---

## 5. Cara kerja suite

1. **`setup()`** login sekali sebagai siswa dan admin, lalu menyimpan cookie
   session. Session dibagikan ke seluruh VU agar rate limit login
   (5x/menit per email+IP) tidak tercapai saat load test.
2. **Discovery** mengambil data nyata (kelas, kategori, materi, kuis, ID edit
   admin) supaya test tidak bergantung pada ID hardcode.
3. **Cookie session Laravel** dideteksi otomatis. Di proyek ini namanya
   `projek-buba-session` (mengikuti `APP_NAME`), bukan `laravel_session`.
   Override bila perlu: `-e SESSION_COOKIE=nama-cookie`.
4. **API token** dibuat sekali di setup dan dihapus lagi di `teardown()`
   (`POST /api/logout`) agar tidak menumpuk di `personal_access_tokens`.
5. Setiap request diberi tag `name` yang stabil sehingga metrik per-endpoint
   mudah dibaca di ringkasan k6.

---

## 6. Threshold (kriteria lulus)

Nilai default (bisa dioverride lewat env):

| Metrik | Default | Env |
|---|---|---|
| `checks` | `> 98%` | — |
| Gagal request per skenario | `< 2%` | `MAX_FAIL_RATE` |
| Web p95 | `< 3000 ms` | `WEB_P95` |
| Web p99 | `< 6000 ms` | `WEB_P99` |
| API p95 | `< 1200 ms` | `API_P95` |
| API p99 | `< 2500 ms` | `API_P99` |

Contoh menyesuaikan target:

```bash
WEB_P95=1500 API_P95=500 ./tests/k6/run.sh load
```

Smoke test hanya memakai threshold `checks > 95%` dan `p(95) < 3000 ms`
karena ada response `302/401/403/404` yang memang disengaja.

Stress & spike sengaja memakai threshold longgar; tujuannya melihat kapan
aplikasi mulai gagal, bukan lulus/gagal.

---

## 7. Melihat hasil

k6 sudah menampilkan ringkasan di terminal:

```
checks.........................: 100.00% ✓ 3136 ✗ 0
http_req_duration..............: avg=71.69ms p(95)=168.83ms p(99)=289.25ms
http_req_failed................: 0.00%  ✓ 0
```

Opsi tambahan:

```bash
# Dashboard web real-time (buka http://localhost:5665)
K6_WEB_DASHBOARD=true ./tests/k6/run.sh load

# Simpan metrik mentah
./tests/k6/run.sh load --out json=reports/load.json

# Ringkasan terstruktur
./tests/k6/run.sh load --summary-export=reports/load-summary.json
```

---

## 8. Catatan & peringatan

- **Rate limit login** adalah 5 percobaan/menit per email+IP. Suite merotasi
  8 akun siswa dan hanya login sekali di setup. Jika menjalankan test berkali-kali
  dalam satu menit, reset dengan:

  ```bash
  php artisan cache:clear
  ```

- **Session dibagikan antar VU.** Ini normal untuk load test Laravel dan
  menghindari rate limit. Jika ingin menguji login per VU secara terpisah,
  gunakan `write.js` (tiap VU login dengan akun berbeda).

- **`write.js` menulis ke database**: menambah baris `rewards`, dan
  `personal_access_tokens` sementara. Jawaban sengaja dibuat salah agar
  bintang 0 dan kategori tidak terkunci. Jalankan di database salinan/staging.
  Reset dengan `php artisan migrate:fresh --seed`.

- **`/download` mengunduh APK 5 MB.** Endpoint ini hanya diuji di `smoke`,
  tidak di load test, agar bandwidth tidak mendominasi hasil.

- **`php artisan serve` single worker.** Jika hasil load test langsung buruk,
  pastikan bukan karena keterbatasan dev server sebelum menyimpulkan performa
  aplikasi.

---

## 9. Troubleshooting

| Gejala | Penyebab umum | Solusi |
|---|---|---|
| `setup: session siswa/admin tersedia` gagal | Email/password salah atau rate limit | Cek env akun, `php artisan cache:clear` |
| `token API tersedia` gagal | Login API kena 429 | Tunggu 1 menit / `php artisan cache:clear` |
| Banyak `403` di halaman siswa | Akun siswa beda kelas dengan data discovery | Pastikan akun ada di `STUDENT_POOL` (semua kelas B) |
| `GET /siswa/kuis-show` 302 | Kategori sudah terkunci (bintang ≥ 3) | Pakai akun baru / reset `rewards` |
| Semua request lambat | Dev server 1 worker | Pakai `PHP_CLI_SERVER_WORKERS=4` atau Apache/nginx |
| `k6: command not found` | k6 belum terpasang | Install k6 |

---

## 10. Rekomendasi alur pengujian

1. `smoke` → pastikan semua endpoint hijau.
2. `load` → baseline performa pada beban normal.
3. `stress` → cari batas aman (berapa VU sebelum error/latency melonjak).
4. `spike` → pastikan aplikasi pulih setelah lonjakan.
5. `soak` → jalankan saat akan rilis, minimal 30 menit.
6. `write` → hanya di staging, untuk memvalidasi alur simpan data.
