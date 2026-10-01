<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kategori;
use App\Models\Quis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuisController extends Controller
{
    /**
     * Menampilkan semua soal kuis
     */
    public function index()
    {
        $quis = Quis::with(['kelas', 'kategori'])
<<<<<<< HEAD
            ->orderBy('id', 'asc')
=======
            ->latest()
>>>>>>> 62312ce (Perbaikan kategori)
            ->get();

        return view('admin.kuis.index', compact('quis'));
    }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
    /**
     * Menampilkan halaman tambah soal
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view(
            'admin.kuis.add',
            compact('kelas', 'kategoris')
        );
    }

    /**
     * Menyimpan soal baru
     */
    public function store(Request $request)
    {
        $request->validate([
<<<<<<< HEAD
            'kelas_id' => 'required|exists:kelas,id',
            'kategori_id' => 'required|exists:kategoris,id',

            'pertanyaan' => [
                'required',
                'string',
                'regex:/^[A-Za-z0-9\s?=+\-]+$/',
            ],
=======
            'kode_kuis' => 'required|string|max:50|unique:quis,kode_kuis',

            'kelas_id' => 'required|exists:kelas,id',

            'kategori_id' => 'required|exists:kategoris,id',

            'pertanyaan' => 'required|string',
>>>>>>> 62312ce (Perbaikan kategori)

            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',

            'jawaban' => 'required|in:A,B,C,D',

<<<<<<< HEAD
            'gambar' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'pertanyaan.required' =>
                'Pertanyaan harus diisi.',

            'pertanyaan.regex' =>
                'Pertanyaan hanya boleh menggunakan huruf, angka, spasi, dan simbol ?, =, +, -.',
        ]);

=======
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


>>>>>>> 62312ce (Perbaikan kategori)
        /*
        |--------------------------------------------------------------------------
        | Pastikan kategori sesuai dengan kelas
        |--------------------------------------------------------------------------
        */

        $kategori = Kategori::where('id', $request->kategori_id)
            ->where('kelas_id', $request->kelas_id)
            ->first();

        if (!$kategori) {
            return back()
                ->withInput()
                ->withErrors([
                    'kategori_id' =>
                        'Kategori yang dipilih tidak sesuai dengan kelas.'
                ]);
        }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
        /*
        |--------------------------------------------------------------------------
        | Cek pertanyaan duplikat berdasarkan kelas
        |--------------------------------------------------------------------------
<<<<<<< HEAD
=======
        |
        | Pertanyaan sama + kelas sama    = ditolak
        | Pertanyaan sama + kelas berbeda = diperbolehkan
        |
>>>>>>> 62312ce (Perbaikan kategori)
        */

        $sudahAda = Quis::whereRaw(
            'LOWER(TRIM(pertanyaan)) = ?',
            [strtolower(trim($request->pertanyaan))]
        )
<<<<<<< HEAD
            ->where('kelas_id', $request->kelas_id)
            ->exists();
=======
        ->where('kelas_id', $request->kelas_id)
        ->exists();

>>>>>>> 62312ce (Perbaikan kategori)

        if ($sudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'pertanyaan' =>
                        'Pertanyaan tersebut sudah ada di kelas yang dipilih. Silakan gunakan pertanyaan lain.'
                ]);
        }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
        /*
        |--------------------------------------------------------------------------
        | Data yang disimpan
        |--------------------------------------------------------------------------
<<<<<<< HEAD
        |
        | kode_kuis tidak dibuat di controller.
        | Kode otomatis dibuat oleh Quis.php.
        |
        */

        $data = [
            'kelas_id' => $request->kelas_id,
            'kategori_id' => $request->kategori_id,
            'pertanyaan' => $request->pertanyaan,
=======
        */

        $data = [
            'kode_kuis' => $request->kode_kuis,

            // Relasi langsung ke kelas
            'kelas_id' => $request->kelas_id,

            // Relasi langsung ke kategori
            'kategori_id' => $request->kategori_id,

            'pertanyaan' => $request->pertanyaan,

>>>>>>> 62312ce (Perbaikan kategori)
            'pilihan_a' => $request->pilihan_a,
            'pilihan_b' => $request->pilihan_b,
            'pilihan_c' => $request->pilihan_c,
            'pilihan_d' => $request->pilihan_d,
<<<<<<< HEAD
            'jawaban' => $request->jawaban,
        ];

=======

            'jawaban' => $request->jawaban,
        ];


>>>>>>> 62312ce (Perbaikan kategori)
        /*
        |--------------------------------------------------------------------------
        | Upload gambar
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request
                ->file('gambar')
                ->store('quis', 'public');
        }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
        /*
        |--------------------------------------------------------------------------
        | Simpan soal
        |--------------------------------------------------------------------------
        */

        Quis::create($data);

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
        return redirect()
            ->route('kuis.index')
            ->with(
                'success',
                'Soal kuis berhasil ditambahkan.'
            );
    }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
    /**
     * Menampilkan detail soal
     */
    public function show(Quis $quis)
    {
        $quis->load(['kelas', 'kategori']);

        return view(
            'admin.kuis.detail',
            compact('quis')
        );
    }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
    /**
     * Menampilkan halaman edit
     */
    public function edit(Quis $quis)
    {
        $quis->load(['kelas', 'kategori']);

        $kelas = Kelas::orderBy('nama_kelas')->get();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view(
            'admin.kuis.edit',
            compact(
                'quis',
                'kelas',
                'kategoris'
            )
        );
    }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
    /**
     * Memperbarui soal
     */
    public function update(Request $request, Quis $quis)
    {
        $request->validate([
<<<<<<< HEAD
            'kelas_id' => 'required|exists:kelas,id',
            'kategori_id' => 'required|exists:kategoris,id',

            'pertanyaan' => [
                'required',
                'string',
                'regex:/^[A-Za-z0-9\s?=+\-]+$/',
            ],

            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',

            'jawaban' => 'required|in:A,B,C,D',

            'gambar' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'pertanyaan.required' =>
                'Pertanyaan harus diisi.',

            'pertanyaan.regex' =>
                'Pertanyaan hanya boleh menggunakan huruf, angka, spasi, dan simbol ?, =, +, -.',
        ]);

=======
            'kode_kuis' =>
                'required|string|max:50|unique:quis,kode_kuis,' . $quis->id,

            'kelas_id' =>
                'required|exists:kelas,id',

            'kategori_id' =>
                'required|exists:kategoris,id',

            'pertanyaan' =>
                'required|string',

            'pilihan_a' =>
                'required|string',

            'pilihan_b' =>
                'required|string',

            'pilihan_c' =>
                'required|string',

            'pilihan_d' =>
                'required|string',

            'jawaban' =>
                'required|in:A,B,C,D',

            'gambar' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


>>>>>>> 62312ce (Perbaikan kategori)
        /*
        |--------------------------------------------------------------------------
        | Pastikan kategori sesuai dengan kelas
        |--------------------------------------------------------------------------
        */

        $kategori = Kategori::where('id', $request->kategori_id)
            ->where('kelas_id', $request->kelas_id)
            ->first();

        if (!$kategori) {
            return back()
                ->withInput()
                ->withErrors([
                    'kategori_id' =>
                        'Kategori yang dipilih tidak sesuai dengan kelas.'
                ]);
        }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
        /*
        |--------------------------------------------------------------------------
        | Cek pertanyaan duplikat berdasarkan kelas
        |--------------------------------------------------------------------------
        */

        $sudahAda = Quis::whereRaw(
            'LOWER(TRIM(pertanyaan)) = ?',
            [strtolower(trim($request->pertanyaan))]
        )
<<<<<<< HEAD
            ->where('kelas_id', $request->kelas_id)
            ->where('id', '!=', $quis->id)
            ->exists();
=======
        ->where('kelas_id', $request->kelas_id)
        ->where('id', '!=', $quis->id)
        ->exists();

>>>>>>> 62312ce (Perbaikan kategori)

        if ($sudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'pertanyaan' =>
                        'Pertanyaan tersebut sudah ada di kelas yang dipilih. Silakan gunakan pertanyaan lain.'
                ]);
        }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
        /*
        |--------------------------------------------------------------------------
        | Data yang diperbarui
        |--------------------------------------------------------------------------
<<<<<<< HEAD
        |
        | Kode kuis tidak diubah saat edit.
        |
        */

        $data = [
            'kelas_id' => $request->kelas_id,
            'kategori_id' => $request->kategori_id,
            'pertanyaan' => $request->pertanyaan,
            'pilihan_a' => $request->pilihan_a,
            'pilihan_b' => $request->pilihan_b,
            'pilihan_c' => $request->pilihan_c,
            'pilihan_d' => $request->pilihan_d,
            'jawaban' => $request->jawaban,
        ];

=======
        */

        $data = [
            'kode_kuis' =>
                $request->kode_kuis,

            // Update kelas secara langsung
            'kelas_id' =>
                $request->kelas_id,

            // Update kategori secara langsung
            'kategori_id' =>
                $request->kategori_id,

            'pertanyaan' =>
                $request->pertanyaan,

            'pilihan_a' =>
                $request->pilihan_a,

            'pilihan_b' =>
                $request->pilihan_b,

            'pilihan_c' =>
                $request->pilihan_c,

            'pilihan_d' =>
                $request->pilihan_d,

            'jawaban' =>
                $request->jawaban,
        ];


>>>>>>> 62312ce (Perbaikan kategori)
        /*
        |--------------------------------------------------------------------------
        | Jika mengganti gambar
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gambar')) {
<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
            if ($quis->gambar) {
                Storage::disk('public')
                    ->delete($quis->gambar);
            }

            $data['gambar'] = $request
                ->file('gambar')
                ->store('quis', 'public');
        }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
        /*
        |--------------------------------------------------------------------------
        | Update soal
        |--------------------------------------------------------------------------
        */

        $quis->update($data);

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
        return redirect()
            ->route('kuis.index')
            ->with(
                'success',
                'Soal kuis berhasil diperbarui.'
            );
    }

<<<<<<< HEAD
=======

>>>>>>> 62312ce (Perbaikan kategori)
    /**
     * Menghapus soal
     */
    public function destroy(Quis $quis)
    {
        if ($quis->gambar) {
            Storage::disk('public')
                ->delete($quis->gambar);
        }

        $quis->delete();

        return redirect()
            ->route('kuis.index')
            ->with(
                'success',
                'Soal kuis berhasil dihapus.'
            );
    }
}
