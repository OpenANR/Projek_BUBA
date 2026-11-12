<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Quis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::get();
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('kategori', 'kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add()
    {
        $kelas = Kelas::get();
        return view('admin.kategori.add', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:30|unique:kategoris,nama_kategori',
            'deskripsi'     => 'required|string',
            'kelas_id'      => 'required|exists:kelas,id',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori telah ada.',
            'nama_kategori.max'      => 'Nama kategori maksimal 30 karakter.',
            'deskripsi.required'     => 'Deskripsi wajib diisi.',
            'kelas_id.required'      => 'Kelas wajib dipilih.',
            'kelas_id.exists'        => 'Kelas tidak valid.',
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
            'slug'          => $this->slugUnik($request->nama_kategori),
            'kelas_id'      => $request->kelas_id,
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
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categories = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:30|unique:kategoris,nama_kategori,' . $categories->id,
            'deskripsi'     => 'required|string',
            'kelas_id'      => 'required|exists:kelas,id',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori telah ada.',
            'nama_kategori.max'      => 'Nama kategori maksimal 30 karakter.',
            'deskripsi.required'     => 'Deskripsi wajib diisi.',
            'kelas_id.required'      => 'Kelas wajib dipilih.',
            'kelas_id.exists'        => 'Kelas tidak valid.',
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
            'slug'          => $this->slugUnik($request->nama_kategori, $categories->id),
            'kelas_id'      => $request->kelas_id,
        ];

        $categories->update($data);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Buat slug unik, atau kirim pesan validasi jika slug sudah dipakai.
     */
    private function slugUnik(string $namaKategori, ?int $abaikanId = null): string
    {
        $slug = Str::slug($namaKategori);

        if ($slug === '') {
            throw ValidationException::withMessages([
                'nama_kategori' => 'Nama kategori tidak valid.',
            ]);
        }

        $query = Kategori::where('slug', $slug);

        if ($abaikanId !== null) {
            $query->where('id', '!=', $abaikanId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'nama_kategori' => 'Nama kategori terlalu mirip dengan kategori yang sudah ada.',
            ]);
        }

        return $slug;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categories = Kategori::findOrFail($id);

        // Kategori dihapus akan menghapus materi & kuis lewat cascade.
        // Kumpulkan dulu file-file terkait agar tidak menjadi file orphan.
        $daftarFile = [];

        foreach (Materi::where('kategori_id', $categories->id)->get() as $materi) {
            foreach (['gambar', 'audio'] as $field) {
                if ($materi->$field) {
                    $daftarFile[] = $materi->$field;
                }
            }
        }

        foreach (Quis::where('kategori_id', $categories->id)->get() as $quis) {
            $gambar = $quis->gambar ?? [];

            if (is_string($gambar)) {
                $decoded = json_decode($gambar, true);
                $gambar = is_array($decoded) ? $decoded : [$gambar];
            }

            if (is_array($gambar)) {
                foreach (array_filter($gambar) as $file) {
                    $daftarFile[] = $file;
                }
            }

            foreach ([
                'audio_pertanyaan',
                'audio_pilihan_a',
                'audio_pilihan_b',
                'audio_pilihan_c',
                'audio_pilihan_d',
            ] as $field) {
                if ($quis->$field) {
                    $daftarFile[] = $quis->$field;
                }
            }
        }

        DB::transaction(function () use ($categories) {
            $categories->delete();
        });

        if (! empty($daftarFile)) {
            Storage::disk('public')->delete(array_unique($daftarFile));
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }

    public function pilihKategori($konten, Kelas $kelas)
    {
        // $dataKelas = Kelas::findOrFail($kelas);
        $kategori = Kategori::where('kelas_id', $kelas->id)->get();
        return view('siswa.kategori', compact('konten', 'kelas', 'kategori'));
    }
}
