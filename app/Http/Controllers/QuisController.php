<?php

namespace App\Http\Controllers;

use App\Models\Quis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuisController extends Controller
{
    /**
     * Menampilkan semua soal kuis.
     */
    public function index()
    {
        $quis = Quis::latest()->get();

        return view('admin.kuis.index', compact('quis'));
    }

    /**
     * Menampilkan form tambah soal.
     */
    public function create()
    {
        return view('admin.kuis.add');
    }

    /**
     * Menyimpan soal baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',

            // Kelas
            'kelas' => 'required|in:A,B',

            // Kategori
            'kategori' => 'required|string',

            // Pilihan jawaban
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',

            // Jawaban benar
            'jawaban' => 'required|in:A,B,C,D',

            // Gambar
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'pertanyaan' => $request->pertanyaan,
            'kelas' => $request->kelas,
            'kategori' => $request->kategori,

            'pilihan_a' => $request->pilihan_a,
            'pilihan_b' => $request->pilihan_b,
            'pilihan_c' => $request->pilihan_c,
            'pilihan_d' => $request->pilihan_d,

            'jawaban' => $request->jawaban,
        ];

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('quis', 'public');
        }

        Quis::create($data);

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Soal kuis berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail soal.
     */
    public function show(Quis $quis)
    {
        return view('admin.kuis.detail', compact('quis'));
    }

    /**
     * Menampilkan form edit soal.
     */
    public function edit(Quis $quis)
    {
        return view('admin.kuis.edit', compact('quis'));
    }

    /**
     * Memperbarui soal.
     */
    public function update(Request $request, Quis $quis)
    {
        $request->validate([
            'pertanyaan' => 'required|string',

            // Kelas
            'kelas' => 'required|in:A,B',

            // Kategori
            'kategori' => 'required|string',

            // Pilihan jawaban
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',

            // Jawaban benar
            'jawaban' => 'required|in:A,B,C,D',

            // Gambar
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'pertanyaan' => $request->pertanyaan,
            'kelas' => $request->kelas,
            'kategori' => $request->kategori,

            'pilihan_a' => $request->pilihan_a,
            'pilihan_b' => $request->pilihan_b,
            'pilihan_c' => $request->pilihan_c,
            'pilihan_d' => $request->pilihan_d,

            'jawaban' => $request->jawaban,
        ];

        // Jika upload gambar baru
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($quis->gambar) {
                Storage::disk('public')->delete($quis->gambar);
            }

            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('quis', 'public');
        }

        $quis->update($data);

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Soal kuis berhasil diperbarui.');
    }

    /**
     * Menghapus soal.
     */
    public function destroy(Quis $quis)
    {
        // Hapus gambar jika ada
        if ($quis->gambar) {
            Storage::disk('public')->delete($quis->gambar);
        }

        // Hapus data soal
        $quis->delete();

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Soal kuis berhasil dihapus.');
    }
}
