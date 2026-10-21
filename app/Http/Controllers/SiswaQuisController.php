<?php

namespace App\Http\Controllers;

use App\Models\Quis;
use App\Models\Kelas;
use App\Models\Kategori;

class SiswaQuisController extends Controller
{
    public function index($kelas, $kategori)
    {
        // Mengambil data kelas yang dipilih
        $dataKelas = Kelas::findOrFail($kelas);

        // Mengambil kategori yang dipilih
        $dataKategori = Kategori::findOrFail($kategori);

        // Memastikan kategori sesuai dengan kelas
        if ((int) $dataKategori->kelas_id !== (int) $dataKelas->id) {
            abort(404, 'Kategori tidak sesuai dengan kelas.');
        }

        // Mengambil soal yang telah dibuat admin
        $quis = Quis::query()
            ->where('kelas_id', $dataKelas->id)
            ->where('kategori_id', $dataKategori->id)
            ->inRandomOrder()
            ->get();

        // Mengirim data soal ke halaman kuis siswa
        return view('siswa.quis', [
            'quis' => $quis,
            'dataKelas' => $dataKelas,
            'dataKategori' => $dataKategori,
        ]);
    }
}
