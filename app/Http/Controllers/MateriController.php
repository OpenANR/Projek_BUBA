<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Materi;
use Illuminate\Support\Str;

class MateriController extends Controller
{
    public function index(){
        $materi = Materi::all();
        $kategori = Kategori::get();
        return view('materi.index', compact(['materi', 'kategori']));
    }

    public function add(){
        $kategori = Kategori::get();
        return view('materi.add', compact('kategori'));
    }

    public function store(Request $request){
        $request->validate([
            'kode_materi' => 'required|string',
            'nama_materi' => 'required|string|max:255',
            'isi_materi' => 'required|string',
            'gambar' => 'nullable|mimes:png,jpg|max:2048',
            'audio' => 'nullable|mimes:mp3,aac',
        ]);

        $data = [
            'kode_materi' => 'MTR-' . Str::upper(Str::random(4)),
            'nama_materi' => $request->nama_materi,
            'isi_materi' => $request->isi_materi,
            'gambar' =>null,
            'audio' => null,
            'kategori_id' => $request->kategori_id
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('materi', 'public');
        }

        if ($request->hasFile('audio')) {
            $data['audio'] = $request->file('audio')->store('audio', 'public');
        }

        Materi::create($data);

        return redirect()->route('index.materi')->with('succes', 'Data berhasil ditambahkan');
    }

    public function show($id){
        $materi = Materi::findOrFail($id);
        return view('materi.detail_materi', compact('materi'));
    }

    public function edit($id) {
        $materi = Materi::findOrFail($id);
        $kategori = Kategori::get();
        return view('materi.edit_materi', compact(['materi', 'kategori']));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'kode_materi' => 'required|string',
            'nama_materi' => 'required|string|max:255',
            'isi_materi' => 'required|string',
            'gambar' => 'nullable|mimes:png,jpg|max:2048',
            'audio' => 'nullable|mimes:mp3,aac',
        ]);

        $materi = Materi::findOrFail($id);

        $data = [
            'kode_materi' => 'MTR-' . Str::upper(Str::random(4)),
            'nama_materi' => $request->nama_materi,
            'isi_materi' => $request->isi_materi,
            'gambar' =>null,
            'audio' => null,
            'kategori_id' => $request->kategori_id
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('materi', 'public');
        }

        if ($request->hasFile('audio')) {
            $data['audio'] = $request->file('audio')->store('audio', 'public');
        }

        $materi->update($data);

        return redirect()->route('index.materi')->with('succes', 'Update data berhasil');
    }

    public function destroy($id) {
        $materi = Materi::findOrFail($id);
        $materi->delete();
        return redirect()->route('index.materi')->with('succes', 'Data berhasil dihapus');
    }
}
