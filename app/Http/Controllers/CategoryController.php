<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kelas;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::get();
        $categories = Kategori::all();
        return view('admin.kategori.index', compact('categories', 'kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string',
            'deskripsi'     => 'required|string',
            'kelas_id'      => 'required|exists:kelas,id',
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
            'kelas_id'      => $request->kelas_id
        ];

        Kategori::create($data);

        return redirect()->route('kategori.index')->with('success', 'Berhasil menambah kategori');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelas = Kelas::get();
        $categories = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('categories', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string',
            'deskripsi'     => 'required|string',
            'kelas_id'      => 'required|exists:kelas,id'
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
            'kelas_id'      => $request->kelas_id
        ];

        $categories = Kategori::findOrFail($id);
        $categories->update($data);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambah');   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
