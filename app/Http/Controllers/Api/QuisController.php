<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quis;

class QuisController extends Controller
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

    public function listKuis($konten, $kelas, $kategori) {

        $kuis = Quis::where('kelas_id', $kelas)
                        ->where('kategori_id', $kategori)
                        ->select('id', 'kode_kuis', 'pertanyaan')
                        ->get();
        
        return response()->json([
            'konten' => $konten,
            'kelas' => $kelas,
            'kategori' => $kategori,
            'kuis' => $kuis
        ]);
    }

    public function showKuis($konten, $kelas, $kategori, $kode_kuis) {

        $dataKuis = Quis::where('kode_kuis', $kode_kuis)->firstOrFail();
        return response()->json([
            'konten' => $konten,
            'kelas' => $kelas,
            'kategori' => $kategori,
            'dataKuis' => $dataKuis
        ]);
    }
}
