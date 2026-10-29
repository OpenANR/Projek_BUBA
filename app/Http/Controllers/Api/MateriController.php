<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;

class MateriController extends Controller
{
    public function listMateri(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $materi = Materi::where('kelas_id', $request->kelas_id)
            ->where('kategori_id', $request->kategori_id)
            ->select('id', 'kode_materi', 'nama_materi', 'gambar')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'kode_materi' => $item->kode_materi,
                    'nama_materi' => $item->nama_materi,
                    'gambar_url' => $item->gambar ? url('storage/' . $item->gambar) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $materi
        ], 200);
    }

    public function showMateri($kode_materi)
    {
        $materi = Materi::where('kode_materi', $kode_materi)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $materi->id,
                'kode_materi' => $materi->kode_materi,
                'nama_materi' => $materi->nama_materi,
                'isi_materi' => $materi->isi_materi,
                'gambar_url' => $materi->gambar ? url('storage/' . $materi->gambar) : null,
                'audio_url' => $materi->audio ? url('storage/' . $materi->audio) : null,
            ]
        ], 200);
    }
}