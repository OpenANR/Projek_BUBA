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
<<<<<<< HEAD
        $categories = Kategori::all();
        return view('admin.kategori.index', compact('categories', 'kelas'));
=======
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('kategori', 'kelas'));
>>>>>>> 62312ce (Perbaikan kategori)
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add()
    {
<<<<<<< HEAD
        return view('admin.kategori.add');
=======
        $kelas = Kelas::get();
        return view('admin.kategori.add', compact('kelas'));
>>>>>>> 62312ce (Perbaikan kategori)
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
<<<<<<< HEAD
        $categories = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('categories', 'kelas'));
=======
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori', 'kelas'));
>>>>>>> 62312ce (Perbaikan kategori)
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
<<<<<<< HEAD
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambah');   
=======
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambah');
>>>>>>> 62312ce (Perbaikan kategori)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
<<<<<<< HEAD
        //
=======
        $categories = Kategori::findOrFail($id);
        $categories->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
>>>>>>> 62312ce (Perbaikan kategori)
    }
}
