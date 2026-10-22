<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function listMateri($konten, $kelas, $kategori) {

        $materi = Materi::where('kelas_id', $kelas)
                        ->where('kategori_id', $kategori)
                        ->select('id', 'kode_materi', 'nama_materi')
                        ->get();
        
        return response()->json([
            'konten' => $konten,
            'kelas' => $kelas,
            'kategori' => $kategori,
            'materi' => $materi
        ]);
    }

    public function showMateri($konten, $kelas, $kategori, $kode_materi) {

        $dataMateri = Materi::where('kode_materi', $kode_materi)->firstOrFail();
        return response()->json([
            'konten' => $konten,
            'kelas' => $kelas,
            'kategori' => $kategori,
            'dataMateri' => $dataMateri
        ]);
    }
}
