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
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.kuis.index', compact('quis'));
    }


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

            // Bisa memilih banyak gambar
            'gambar' => 'nullable|array',

            // Maksimal 2 MB setiap gambar
            'gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            'audio' => 'nullable|mimes:mp3,wav,ogg|max:10240',

        ], [

            'pertanyaan.required' =>
                'Pertanyaan harus diisi.',

            'pertanyaan.regex' =>
                'Pertanyaan hanya boleh menggunakan huruf, angka, spasi, dan simbol ?, =, +, -.',

            'gambar.*.image' =>
                'File gambar harus berupa gambar.',

            'gambar.*.mimes' =>
                'Format gambar harus JPG, JPEG, PNG, atau WEBP.',

            'gambar.*.max' =>
                'Ukuran setiap gambar maksimal 2 MB.',

            'audio.mimes' =>
                'Format audio harus MP3, WAV, atau OGG.',

            'audio.max' =>
                'Ukuran audio maksimal 10 MB.',

        ]);


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


        /*
        |--------------------------------------------------------------------------
        | Cek pertanyaan duplikat berdasarkan kelas
        |--------------------------------------------------------------------------
        */

        $sudahAda = Quis::whereRaw(
            'LOWER(TRIM(pertanyaan)) = ?',
            [strtolower(trim($request->pertanyaan))]
        )
            ->where('kelas_id', $request->kelas_id)
            ->exists();

        if ($sudahAda) {

            return back()
                ->withInput()
                ->withErrors([
                    'pertanyaan' =>
                        'Pertanyaan tersebut sudah ada di kelas yang dipilih. Silakan gunakan pertanyaan lain.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Data soal
        |--------------------------------------------------------------------------
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


        /*
        |--------------------------------------------------------------------------
        | Upload banyak gambar
        |--------------------------------------------------------------------------
        */

        $gambarPaths = [];

        if ($request->hasFile('gambar')) {

            foreach ($request->file('gambar') as $gambar) {

                $gambarPaths[] = $gambar->store(
                    'quis/gambar',
                    'public'
                );

            }

        }

        $data['gambar'] = $gambarPaths;


        /*
        |--------------------------------------------------------------------------
        | Upload audio
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('audio')) {

            $data['audio'] = $request
                ->file('audio')
                ->store('quis/audio', 'public');

        }


        /*
        |--------------------------------------------------------------------------
        | Simpan soal
        |--------------------------------------------------------------------------
        */

        Quis::create($data);


        return redirect()
            ->route('kuis.index')
            ->with(
                'success',
                'Soal kuis berhasil ditambahkan.'
            );
    }


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


    /**
     * Memperbarui soal
     */
    public function update(Request $request, Quis $quis)
    {
        $request->validate([

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

            // Bisa mengganti dengan banyak gambar
            'gambar' => 'nullable|array',

            // Maksimal 2 MB setiap gambar
            'gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            'audio' => 'nullable|mimes:mp3,wav,ogg|max:10240',

        ], [

            'pertanyaan.required' =>
                'Pertanyaan harus diisi.',

            'pertanyaan.regex' =>
                'Pertanyaan hanya boleh menggunakan huruf, angka, spasi, dan simbol ?, =, +, -.',

            'gambar.*.image' =>
                'File gambar harus berupa gambar.',

            'gambar.*.mimes' =>
                'Format gambar harus JPG, JPEG, PNG, atau WEBP.',

            'gambar.*.max' =>
                'Ukuran setiap gambar maksimal 2 MB.',

            'audio.mimes' =>
                'Format audio harus MP3, WAV, atau OGG.',

            'audio.max' =>
                'Ukuran audio maksimal 10 MB.',

        ]);


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


        /*
        |--------------------------------------------------------------------------
        | Cek pertanyaan duplikat berdasarkan kelas
        |--------------------------------------------------------------------------
        */

        $sudahAda = Quis::whereRaw(
            'LOWER(TRIM(pertanyaan)) = ?',
            [strtolower(trim($request->pertanyaan))]
        )
            ->where('kelas_id', $request->kelas_id)
            ->where('id', '!=', $quis->id)
            ->exists();

        if ($sudahAda) {

            return back()
                ->withInput()
                ->withErrors([
                    'pertanyaan' =>
                        'Pertanyaan tersebut sudah ada di kelas yang dipilih. Silakan gunakan pertanyaan lain.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Data yang diperbarui
        |--------------------------------------------------------------------------
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


        /*
        |--------------------------------------------------------------------------
        | Ganti gambar lama dengan gambar baru
        |--------------------------------------------------------------------------
        |
        | Jika user memilih gambar baru:
        | 1. Semua gambar lama dihapus dari storage.
        | 2. Gambar baru disimpan.
        | 3. Path gambar baru disimpan ke database.
        |
        | Jika user tidak memilih gambar baru:
        | gambar lama tetap dipertahankan.
        |
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gambar')) {

            /*
            | Ambil gambar lama
            */

            $gambarLama = $quis->gambar ?? [];

            if (!is_array($gambarLama)) {

                $gambarLama = [$gambarLama];

            }


            /*
            | Hapus semua file gambar lama
            */

            foreach ($gambarLama as $file) {

                if ($file) {

                    Storage::disk('public')
                        ->delete($file);

                }

            }


            /*
            | Upload gambar baru
            */

            $gambarPaths = [];

            foreach ($request->file('gambar') as $gambar) {

                $gambarPaths[] = $gambar->store(
                    'quis/gambar',
                    'public'
                );

            }


            /*
            | Simpan path gambar baru
            */

            $data['gambar'] = $gambarPaths;

        }


        /*
        |--------------------------------------------------------------------------
        | Ganti audio jika ada audio baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('audio')) {

            if ($quis->audio) {

                Storage::disk('public')
                    ->delete($quis->audio);

            }

            $data['audio'] = $request
                ->file('audio')
                ->store('quis/audio', 'public');

        }


        /*
        |--------------------------------------------------------------------------
        | Update soal
        |--------------------------------------------------------------------------
        */

        $quis->update($data);


        return redirect()
            ->route('kuis.index')
            ->with(
                'success',
                'Soal kuis berhasil diperbarui.'
            );
    }


    /**
     * Menghapus soal
     */
    public function destroy(Quis $quis)
    {
        /*
        |--------------------------------------------------------------------------
        | Hapus semua gambar
        |--------------------------------------------------------------------------
        */

        $gambar = $quis->gambar ?? [];

        if (!is_array($gambar)) {

            $gambar = [$gambar];

        }

        foreach ($gambar as $file) {

            if ($file) {

                Storage::disk('public')
                    ->delete($file);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Hapus audio
        |--------------------------------------------------------------------------
        */

        if ($quis->audio) {

            Storage::disk('public')
                ->delete($quis->audio);

        }


        /*
        |--------------------------------------------------------------------------
        | Hapus data soal
        |--------------------------------------------------------------------------
        */

        $quis->delete();


        return redirect()
            ->route('kuis.index')
            ->with(
                'success',
                'Soal kuis berhasil dihapus.'
            );
    }
}
