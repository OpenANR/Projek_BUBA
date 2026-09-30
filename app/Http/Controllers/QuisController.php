<?php

namespace App\Http\Controllers;

use App\Models\Quis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuisController extends Controller
{
    public function index()
    {
        $quis = Quis::latest()->get();

        return view('admin.kuis.index', compact('quis'));
    }

    public function create()
    {
        return view('admin.kuis.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'kelas' => 'required|in:A,B',
            'kategori' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'jawaban' => 'required|in:A,B,C,D',
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

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('quis', 'public');
        }

        Quis::create($data);

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Soal kuis berhasil ditambahkan.');
    }

    public function show(Quis $quis)
    {
        return view('admin.kuis.detail', compact('quis'));
    }

    public function edit(Quis $quis)
    {
        return view('admin.kuis.edit', compact('quis'));
    }

    public function update(Request $request, Quis $quis)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'kelas' => 'required|in:A,B',
            'kategori' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'jawaban' => 'required|in:A,B,C,D',
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

        if ($request->hasFile('gambar')) {

            if ($quis->gambar) {
                Storage::disk('public')->delete($quis->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('quis', 'public');
        }

        $quis->update($data);

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Soal kuis berhasil diperbarui.');
    }

    public function destroy(Quis $quis)
    {
        if ($quis->gambar) {
            Storage::disk('public')->delete($quis->gambar);
        }

        $quis->delete();

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Soal kuis berhasil dihapus.');
    }
}
