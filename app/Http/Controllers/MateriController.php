<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Materi;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class MateriController extends Controller
{
    public function index(){
        $materi = Materi::all();
        $kategori = Kategori::get();
        return view('admin.materi.index', compact(['materi', 'kategori']));
    }

    public function add(){
        $kategori = Kategori::get();
        return view('admin.materi.add', compact('kategori'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_materi' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'isi_materi'  => 'required|string',
            'gambar'      => 'nullable|mimes:png,jpg|max:2048',
            'audio'       => 'nullable|mimes:mp3,aac',
        ]);

        $data = [
            'nama_materi' => $request->nama_materi,
            'isi_materi'  => $request->isi_materi,
            'gambar'      => null,
            'audio'       => null,
            'kategori_id' => $request->kategori_id
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('materi', 'public');
        }

        if ($request->hasFile('audio')) {
            $data['audio'] = $request->file('audio')->store('audio', 'public');
        }

        Materi::create($data);

        return redirect()->route('materi.index')->with('succes', 'Data berhasil ditambahkan');
    }

    public function show(Materi $materi){
        $categories = Kategori::get();
        return view('admin.materi.detail', compact('materi', 'categories'));
    }

    public function edit(Materi $materi) {
        $kategori = Kategori::get();
        return view('admin.materi.edit', compact(['materi', 'kategori']));
    }

    public function update(Request $request, Materi $materi) {
        $request->validate([
            'nama_materi' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'isi_materi'  => 'required|string',
            'gambar'      => 'nullable|mimes:png,jpg|max:2048',
            'audio'       => 'nullable|mimes:mp3,aac',
        ]);

        $data = [
            'nama_materi' => $request->nama_materi,
            'isi_materi'  => $request->isi_materi,
            'kategori_id' => $request->kategori_id
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('materi', 'public');
        }

        if ($request->hasFile('audio')) {
            $data['audio'] = $request->file('audio')->store('audio', 'public');
        }

        $materi->update($data);

        return redirect()->route('materi.index')->with('succes', 'Update data berhasil');
    }

    public function destroy(Materi $materi) {

        if ($materi->gambar && Storage::disk('public')->exists($materi->gambar)) {
            Storage::disk('public')->delete($materi->gambar);
        }
        $materi->delete();
        return redirect()->route('materi.index')->with('success', 'Data berhasil dihapus');
    }
}
