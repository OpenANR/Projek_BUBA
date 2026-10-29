<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Kelas;

class CategoryController extends Controller
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

    public function pilihKategori($kelas_id) {
        $dataKelas = is_numeric($kelas_id)
            ? Kelas::find($kelas_id)
            : Kelas::where('nama_kelas', $kelas_id)->first();

        if (!$dataKelas) {
            return response()->json([
                'success' => false,
                'message' => 'Data kelas tidak ditemukan'
            ], 404);
        }

        $kategori = Kategori::where('kelas_id', $dataKelas->id)->get();

        return response()->json([
            'success' => true,
            'dataKelas' => $dataKelas,
            'kategori' => $kategori
        ]);
    }
}
