<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::withCount('siswas')->orderBy('nama_kelas')->get();
        return response()->json([
            'status' => 'Data berhasil tampil !',
            'data' => $kelas
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:5', 'regex:/^[a-zA-Z0-9-]+$/', 'unique:kelas,nama_kelas'],
        ]);

        $data = Kelas::create($validated);

        return response()->json([
            'status' => 'Data kelas berhasil ditambahkan',
            'data' => $data
        ], 201);
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
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:10',
                'regex:/\A[A-Za-z0-9-]+\z/',
                Rule::unique('kelas', 'nama_kelas')->ignore($kelas->id),
            ],
        ]);

        $kelas->update($validated);

        return response()->json([
            'status' => 'Data kelas berhasil diperbarui',
            'data' => $kelas
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);

        if ($kelas->siswas()->exists() || $kelas->kategoris()->exists()) {
            return redirect()->route('kelas.index')->with(
                'error',
                'Kelas tidak dapat dihapus karena masih digunakan oleh siswa atau kategori.'
            );
        }

        $kelas->delete();

        return response()->json([
            'status' => 'Kelas berhasil dihapus',
            'data' => $kelas
        ], 200);
    }
}
