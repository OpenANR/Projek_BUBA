<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    // =========================================================
    // MENAMPILKAN DATA MATERI UNTUK ADMIN
    // =========================================================
    public function index(Request $request)
    {
        $materi = Materi::all();
        $kategori = Kategori::get();
        $kelas = Kelas::get();

        if ($request->wantsJson()) {
            return response()->json(
                compact('materi', 'kategori', 'kelas')
            );
        }

        return view(
            'admin.materi.index',
            compact('materi', 'kategori', 'kelas')
        );
    }

    // =========================================================
    // FORM TAMBAH MATERI
    // =========================================================
    public function add()
    {
        $kategori = Kategori::get();
        $kelas = Kelas::get();

        return view(
            'admin.materi.add',
            compact('kategori', 'kelas')
        );
    }

    // =========================================================
    // MENYIMPAN MATERI BARU
    // =========================================================
    public function store(Request $request)
    {
        $request->validate([
            'nama_materi' => [
                'required',
                'string',
                'max:25',
                'regex:/^[A-Za-z0-9 ]+$/',
            ],
            'kategori_id' => 'required|exists:kategoris,id',
            'kelas_id' => 'required|exists:kelas,id',
            'isi_materi' => 'required|string',
            'gambar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'audio' => 'nullable|mimes:mp3,aac,wav,ogg',
        ], [
            'nama_materi.required' => 'Nama materi harus diisi.',
            'nama_materi.max' => 'Nama materi tidak boleh lebih dari 25 karakter.',
            'nama_materi.regex' => 'Nama materi hanya boleh menggunakan huruf, angka, dan spasi.',
            'kategori_id.required' => 'Kategori harus diisi.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'kelas_id.required' => 'Kelas harus diisi.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.',
            'isi_materi.required' => 'Isi materi harus diisi.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat PNG, JPG, atau JPEG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
            'audio.mimes' => 'Audio harus berformat MP3, AAC, WAV, atau OGG.',
        ]);

        $data = [
            'nama_materi' => $request->nama_materi,
            'isi_materi' => $request->isi_materi,
            'gambar' => null,
            'audio' => null,
            'kategori_id' => $request->kategori_id,
            'kelas_id' => $request->kelas_id,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('materi', 'public');
        }

        if ($request->hasFile('audio')) {
            $data['audio'] = $request->file('audio')
                ->store('audio', 'public');
        }

        Materi::create($data);

        return redirect()
            ->route('materi.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    // =========================================================
    // DETAIL MATERI UNTUK ADMIN
    // =========================================================
    public function show(Materi $materi)
    {
        $categories = Kategori::get();

        return view(
            'admin.materi.detail',
            compact('materi', 'categories')
        );
    }

    // =========================================================
    // FORM EDIT MATERI
    // =========================================================
    public function edit(Materi $materi)
    {
        $kategori = Kategori::get();
        $kelas = Kelas::get();

        return view(
            'admin.materi.edit',
            compact('materi', 'kategori', 'kelas')
        );
    }

    // =========================================================
    // MEMPERBARUI MATERI
    // =========================================================
    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'nama_materi' => [
                'required',
                'string',
                'max:25',
                'regex:/^[A-Za-z0-9 ]+$/',
            ],
            'kategori_id' => 'required|exists:kategoris,id',
            'kelas_id' => 'required|exists:kelas,id',
            'isi_materi' => 'required|string',
            'gambar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'audio' => 'nullable|mimes:mp3,aac,wav,ogg',
        ], [
            'nama_materi.required' => 'Nama materi harus diisi.',
            'nama_materi.max' => 'Nama materi tidak boleh lebih dari 25 karakter.',
            'nama_materi.regex' => 'Nama materi hanya boleh menggunakan huruf, angka, dan spasi.',
            'kategori_id.required' => 'Kategori harus diisi.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'kelas_id.required' => 'Kelas harus diisi.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.',
            'isi_materi.required' => 'Isi materi harus diisi.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat PNG, JPG, atau JPEG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
            'audio.mimes' => 'Audio harus berformat MP3, AAC, WAV, atau OGG.',
        ]);

        $data = [
            'nama_materi' => $request->nama_materi,
            'isi_materi' => $request->isi_materi,
            'kategori_id' => $request->kategori_id,
            'kelas_id' => $request->kelas_id,
        ];

        // Mengganti gambar jika ada gambar baru
        if ($request->hasFile('gambar')) {
            if (
                $materi->gambar &&
                Storage::disk('public')->exists($materi->gambar)
            ) {
                Storage::disk('public')->delete($materi->gambar);
            }

            $data['gambar'] = $request->file('gambar')
                ->store('materi', 'public');
        }

        // Mengganti audio jika ada audio baru
        if ($request->hasFile('audio')) {
            if (
                $materi->audio &&
                Storage::disk('public')->exists($materi->audio)
            ) {
                Storage::disk('public')->delete($materi->audio);
            }

            $data['audio'] = $request->file('audio')
                ->store('audio', 'public');
        }

        $materi->update($data);

        return redirect()
            ->route('materi.index')
            ->with('success', 'Update data berhasil.');
    }

    // =========================================================
    // MENGHAPUS MATERI
    // =========================================================
    public function destroy(Materi $materi)
    {
        if (
            $materi->gambar &&
            Storage::disk('public')->exists($materi->gambar)
        ) {
            Storage::disk('public')->delete($materi->gambar);
        }

        if (
            $materi->audio &&
            Storage::disk('public')->exists($materi->audio)
        ) {
            Storage::disk('public')->delete($materi->audio);
        }

        $materi->delete();

        return redirect()
            ->route('materi.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    // =========================================================
    // DAFTAR MATERI UNTUK SISWA
    // Pilih kategori -> tampilkan card materi
    // =========================================================
    public function listMateri(
        $konten,
        Kelas $kelas,
        Kategori $kategori
    ) {
        $dataMateri = Materi::where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->get();

        return view(
            'siswa.materi',
            compact('konten', 'kelas', 'kategori', 'dataMateri')
        );
    }

    // =========================================================
    // DETAIL MATERI UNTUK SISWA
    // Klik card -> tampilkan detail satu materi
    // =========================================================
    public function showMateri(
        $konten,
        Kelas $kelas,
        Kategori $kategori,
        $materi
    ) {
        $dataMateri = Materi::where('kode_materi', $materi)
            ->where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->firstOrFail();

        return view(
            'siswa.detail-materi',
            compact('konten', 'kelas', 'kategori', 'dataMateri')
        );
    }
}