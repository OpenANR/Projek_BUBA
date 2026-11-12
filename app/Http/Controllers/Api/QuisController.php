<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quis;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class QuisController extends Controller
{
    /**
     * Memeriksa apakah kategori sudah terkunci.
     * Kategori terkunci jika siswa pernah mendapatkan
     * minimal 3 bintang pada kategori tersebut.
     */
    private function kuisSudahTerkunci($userId, $kelasId, $kategoriId)
    {
        return Reward::where('user_id', $userId)
            ->where('jumlah_bintang', '>=', 3)
            ->whereHas('quis', function ($query) use ($kelasId, $kategoriId) {
                $query->where('kelas_id', $kelasId)
                    ->where('kategori_id', $kategoriId);
            })
            ->exists();
    }

    /**
     * Mengambil daftar soal kuis untuk siswa.
     * Kunci jawaban tidak dikirim ke Flutter.
     */
    
    public function listKuis(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'kategori_id' => [
                'required',
                Rule::exists('kategoris', 'id')
                    ->where('kelas_id', $request->input('kelas_id')),
            ],
        ], [
            'kategori_id.exists' => 'Kategori tidak sesuai dengan kelas yang dipilih.',
        ]);

        $userId = $request->user()->id;
        $kelasId = $validated['kelas_id'];
        $kategoriId = $validated['kategori_id'];

        // Periksa apakah kategori sudah terkunci.
        $terkunci = $this->kuisSudahTerkunci(
            $userId,
            $kelasId,
            $kategoriId
        );

        // Ambil soal berdasarkan kelas dan kategori.
        $kuis = Quis::where('kelas_id', $kelasId)
            ->where('kategori_id', $kategoriId)
            ->inRandomOrder()
            ->get()
            ->map(function ($item) {

                // Baca data gambar, baik berbentuk JSON maupun array.
                $gambar = $item->gambar ?? [];

                if (is_string($gambar)) {
                    $decoded = json_decode($gambar, true);

                    $gambar = json_last_error() === JSON_ERROR_NONE
                        ? $decoded
                        : [$gambar];
                }

                if (!is_array($gambar)) {
                    $gambar = [];
                }

                // Buat URL gambar.
                $gambarUrls = collect($gambar)
                    ->filter()
                    ->map(function ($path) {
                        return Storage::disk('public')->url(
                            ltrim($path, '/')
                        );
                    })
                    ->values();

                // Buat URL audio.
                $buatUrlAudio = function ($path) {
                    return $path
                        ? Storage::disk('public')->url(
                            ltrim($path, '/')
                        )
                        : null;
                };

                return [
                    'id' => $item->id,
                    'kode_kuis' => $item->kode_kuis,
                    'pertanyaan' => $item->pertanyaan,

                    'gambar_urls' => $gambarUrls,

                    'audio_pertanyaan_url' => $buatUrlAudio(
                        $item->audio_pertanyaan
                    ),

                    'pilihan_a' => $item->pilihan_a,
                    'pilihan_b' => $item->pilihan_b,
                    'pilihan_c' => $item->pilihan_c,
                    'pilihan_d' => $item->pilihan_d,

                    'audio_pilihan_a_url' => $buatUrlAudio(
                        $item->audio_pilihan_a
                    ),

                    'audio_pilihan_b_url' => $buatUrlAudio(
                        $item->audio_pilihan_b
                    ),

                    'audio_pilihan_c_url' => $buatUrlAudio(
                        $item->audio_pilihan_c
                    ),

                    'audio_pilihan_d_url' => $buatUrlAudio(
                        $item->audio_pilihan_d
                    ),
                ];
            });

        return response()->json([
            'success' => true,
            'total_soal' => $kuis->count(),
            'terkunci' => $terkunci,
            'message' => $terkunci
                ? 'Kategori kuis sudah terkunci.'
                : 'Daftar kuis berhasil diambil.',
            'data' => $kuis,
        ], 200);
    }

    /**
     * Mengirim jawaban siswa, menghitung nilai,
     * menghitung bintang, dan menyimpan reward.
     */
    public function submitKuis(Request $request)
    {
        $validated = $request->validate([
            'quis_id' => 'required|integer|exists:quis,id',
            'kelas_id' => 'required|exists:kelas,id',
            'kategori_id' => [
                'required',
                Rule::exists('kategoris', 'id')
                    ->where('kelas_id', $request->input('kelas_id')),
            ],
            'jawaban' => 'required|array|min:1',
            'jawaban.*' => 'required|in:A,B,C,D',
        ], [
            'kategori_id.exists' => 'Kategori tidak sesuai dengan kelas yang dipilih.',
        ]);

        $userId = $request->user()->id;
        $jawabanSiswa = $request->jawaban;
        $kelasId = (int) $request->kelas_id;
        $kategoriId = (int) $request->kategori_id;

        // Ambil SEMUA soal pada kelas dan kategori ini, bukan hanya yang dikirim siswa.
        $daftarSoal = Quis::where('kelas_id', $kelasId)
            ->where('kategori_id', $kategoriId)
            ->get();

        if ($daftarSoal->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Soal kuis tidak ditemukan atau tidak valid.',
            ], 422);
        }

        // Wajib menjawab seluruh soal; mencegah skor tinggi dari jawaban parsial.
        $idSoal = $daftarSoal->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->sort()
            ->values()
            ->all();

        $idJawaban = collect(array_keys($jawabanSiswa))
            ->map(fn ($id) => (string) $id)
            ->sort()
            ->values()
            ->all();

        if ($idSoal !== $idJawaban) {
            return response()->json([
                'success' => false,
                'message' => 'Semua soal kuis harus dijawab sebelum dikirim.',
            ], 422);
        }

        // Terapkan aturan kunci yang sama seperti alur kuis web.
        if ($this->kuisSudahTerkunci($userId, $kelasId, $kategoriId)) {
            return response()->json([
                'success' => false,
                'message' => 'Kuis sudah terkunci karena kamu telah mendapatkan minimal 3 bintang! ⭐',
                'terkunci' => true,
            ], 403);
        }

        $benar = 0;

        foreach ($daftarSoal as $soal) {
            $jawabanDipilih = strtoupper(
                $jawabanSiswa[$soal->id] ?? ''
            );

            if ($jawabanDipilih === strtoupper($soal->jawaban)) {
                $benar++;
            }
        }

        $total = $daftarSoal->count();
        $salah = $total - $benar;

        $nilai = (int) round(($benar / $total) * 100);

        // Aturan perolehan bintang BUBA.
        if ($nilai >= 90) {
            $bintang = 5;
        } elseif ($nilai >= 70) {
            $bintang = 4;
        } elseif ($nilai >= 50) {
            $bintang = 3;
        } elseif ($nilai >= 20) {
            $bintang = 2;
        } elseif ($nilai >= 1) {
            $bintang = 1;
        } else {
            $bintang = 0;
        }

        // Simpan ke tabel rewards; cek kunci sekali lagi di dalam transaksi
        // agar dua permintaan bersamaan tidak sama-sama lolos.
        $quisId = $daftarSoal->first()->id; // representasi soal kategori ini

        $reward = DB::transaction(function () use (
            $userId,
            $quisId,
            $kelasId,
            $kategoriId,
            $benar,
            $salah,
            $nilai,
            $bintang
        ) {
            User::whereKey($userId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($this->kuisSudahTerkunci($userId, $kelasId, $kategoriId)) {
                return null;
            }

            return Reward::create([
                'user_id' => $userId,
                'quis_id' => $quisId,
                'jumlah_benar' => $benar,
                'jumlah_salah' => $salah,
                'skor' => $nilai,
                'jumlah_bintang' => $bintang,
            ]);
        });

        if (! $reward) {
            return response()->json([
                'success' => false,
                'message' => 'Kuis sudah terkunci karena kamu telah mendapatkan minimal 3 bintang! ⭐',
                'terkunci' => true,
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kuis berhasil diselesaikan!',
            'hasil' => [
                'quis_id' => $quisId,
                'total_soal' => $total,
                'jumlah_benar' => $benar,
                'jumlah_salah' => $salah,
                'skor' => $nilai,
                'jumlah_bintang' => $bintang,
                'terkunci' => $bintang >= 3,
            ],
        ], 200);
    }

    /**
     * Mengambil riwayat hasil kuis siswa.
     */
    public function riwayatHasil(Request $request)
    {
        $userId = $request->user()->id;

        $rewards = Reward::where('user_id', $userId)
            ->with(['quis.kelas', 'quis.kategori'])
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,

                    'quis_id' => $item->quis_id,

                    'kelas' => $item->quis?->kelas?->nama_kelas,

                    'kategori' => $item->quis?->kategori?->nama_kategori,

                    'skor' => $item->skor,

                    'jumlah_benar' => $item->jumlah_benar,

                    'jumlah_salah' => $item->jumlah_salah,

                    'jumlah_bintang' => $item->jumlah_bintang,

                    'tanggal' => $item->created_at
                        ? $item->created_at->format('d M Y H:i')
                        : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $rewards,
        ], 200);
    }

}
