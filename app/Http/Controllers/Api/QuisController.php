<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quis;
use App\Models\Reward;
use Illuminate\Support\Facades\DB;

class QuisController extends Controller
{
    // Mengambil daftar soal kuis untuk dikerjakan (kunci jawaban disembunyikan)
    public function listKuis(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $kuis = Quis::where('kelas_id', $request->kelas_id)
            ->where('kategori_id', $request->kategori_id)
            ->inRandomOrder()
            ->get()
            ->makeHidden(['jawaban']) // SEMBUNYIKAN KUNCI JAWABAN DARI SISWA
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'kode_kuis' => $item->kode_kuis,
                    'pertanyaan' => $item->pertanyaan,
                    'gambar_urls' => collect($item->gambar ?? [])->map(fn($g) => url('storage/' . $g)),
                    'audio_pertanyaan_url' => $item->audio_pertanyaan ? url('storage/' . $item->audio_pertanyaan) : null,
                    'pilihan_a' => $item->pilihan_a,
                    'pilihan_b' => $item->pilihan_b,
                    'pilihan_c' => $item->pilihan_c,
                    'pilihan_d' => $item->pilihan_d,
                    'audio_pilihan_a_url' => $item->audio_pilihan_a ? url('storage/' . $item->audio_pilihan_a) : null,
                    'audio_pilihan_b_url' => $item->audio_pilihan_b ? url('storage/' . $item->audio_pilihan_b) : null,
                    'audio_pilihan_c_url' => $item->audio_pilihan_c ? url('storage/' . $item->audio_pilihan_c) : null,
                    'audio_pilihan_d_url' => $item->audio_pilihan_d ? url('storage/' . $item->audio_pilihan_d) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'total_soal' => $kuis->count(),
            'data' => $kuis,
        ], 200);
    }

    // Submit jawaban dari Flutter, hitung nilai, dan simpan Reward
    public function submitKuis(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'jawaban' => 'required|array|min:1', // Format: {"1": "A", "2": "B"} (id_soal => pilihan)
            'jawaban.*' => 'required|in:A,B,C,D',
        ]);

        $userId = $request->user()->id;
        $jawabanSiswa = $request->jawaban;
        $soalIds = array_keys($jawabanSiswa);

        // Ambil soal asli beserta kunci jawabannya dari database
        $daftarSoal = Quis::whereIn('id', $soalIds)
            ->where('kelas_id', $request->kelas_id)
            ->where('kategori_id', $request->kategori_id)
            ->get();

        if ($daftarSoal->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Soal kuis tidak ditemukan atau tidak valid.',
            ], 422);
        }

        $benar = 0;
        foreach ($daftarSoal as $soal) {
            $jawabanDipilih = strtoupper($jawabanSiswa[$soal->id] ?? '');
            if ($jawabanDipilih === strtoupper($soal->jawaban)) {
                $benar++;
            }
        }

        $total = $daftarSoal->count();
        $salah = $total - $benar;
        $nilai = $total > 0 ? (int) round(($benar / $total) * 100) : 0;

        // Hitung bintang sesuai aturan BUBA
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

        // Simpan ke tabel rewards
        $reward = Reward::create([
            'user_id' => $userId,
            'quis_id' => $daftarSoal->first()->id, // representasi soal kategori ini
            'jumlah_benar' => $benar,
            'jumlah_salah' => $salah,
            'skor' => $nilai,
            'jumlah_bintang' => $bintang,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kuis berhasil diselesaikan!',
            'hasil' => [
                'total_soal' => $total,
                'jumlah_benar' => $benar,
                'jumlah_salah' => $salah,
                'skor' => $nilai,
                'jumlah_bintang' => $bintang,
                'terkunci' => $bintang >= 3,
            ]
        ], 200);
    }

    // Melihat riwayat pengerjaan kuis siswa
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
                    'kelas' => $item->quis?->kelas?->nama_kelas,
                    'kategori' => $item->quis?->kategori?->nama_kategori,
                    'skor' => $item->skor,
                    'jumlah_benar' => $item->jumlah_benar,
                    'jumlah_salah' => $item->jumlah_salah,
                    'jumlah_bintang' => $item->jumlah_bintang,
                    'tanggal' => $item->created_at->format('d M Y H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $rewards
        ], 200);
    }
}