<?php

namespace App\Http\Controllers;

// Menggunakan model yang berhubungan dengan data materi
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Materi;

use Illuminate\Http\Request;

// Digunakan untuk mengelola file gambar dan audio
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    // =========================================================
    // MENAMPILKAN DATA MATERI
    // =========================================================
    public function index(Request $request)
    {
        // Mengambil semua data materi
        $materi = Materi::all();

        // Mengambil semua data kategori
        $kategori = Kategori::get();

        // Mengambil semua data kelas
        $kelas = Kelas::get();

        // Jika request berasal dari API / meminta format JSON
        if ($request->wantsJson()) {
            return response()->json(
                compact('materi', 'kategori', 'kelas')
            );
        }

        // Menampilkan halaman admin.materi.index
        // sekaligus mengirim data materi, kategori, dan kelas
        return view(
            'admin.materi.index',
            compact('materi', 'kategori', 'kelas')
        );
    }


    // =========================================================
    // MENAMPILKAN FORM TAMBAH MATERI
    // =========================================================
    public function add()
    {
        // Mengambil semua kategori
        $kategori = Kategori::get();

        // Mengambil semua kelas
        $kelas = Kelas::get();

        // Menampilkan halaman form tambah materi
        return view(
            'admin.materi.add',
            compact('kategori', 'kelas')
        );
    }


    // =========================================================
    // MENYIMPAN DATA MATERI BARU
    // =========================================================
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $request->validate(
            [
                // Nama materi wajib diisi,
                // berupa teks, maksimal 25 karakter,
                // hanya boleh huruf, angka, dan spasi
                'nama_materi' => [
                    'required',
                    'string',
                    'max:25',
                    'regex:/^[A-Za-z0-9 ]+$/',
                ],

                // Kategori wajib dipilih
                // dan ID harus ada di tabel kategoris
                'kategori_id' => [
                    'required',
                    'exists:kategoris,id',
                ],

                // Kelas wajib dipilih
                // dan ID harus ada di tabel kelas
                'kelas_id' => [
                    'required',
                    'exists:kelas,id',
                ],

                // Isi materi wajib berupa teks
                'isi_materi' => [
                    'required',
                    'string',
                ],

                // Gambar tidak wajib.
                // Jika ada, hanya boleh PNG, JPG, JPEG
                // dengan ukuran maksimal 2 MB
                'gambar' => [
                    'nullable',
                    'mimes:png,jpg,jpeg',
                    'max:2048',
                ],

                // Audio tidak wajib.
                // Jika ada, format yang diperbolehkan
                // MP3, AAC, WAV, atau OGG
                'audio' => [
                    'nullable',
                    'mimes:mp3,aac,wav,ogg',
                ],
            ],

            // Pesan error validasi
            [
                'nama_materi.required' =>
                    'Nama materi harus diisi.',

                'nama_materi.max' =>
                    'Nama materi tidak boleh lebih dari 25 karakter.',

                'nama_materi.regex' =>
                    'Nama materi hanya boleh menggunakan huruf, angka, dan spasi.',

                'kategori_id.required' =>
                    'Kategori harus diisi.',

                'kategori_id.exists' =>
                    'Kategori yang dipilih tidak valid.',

                'kelas_id.required' =>
                    'Kelas harus diisi.',

                'kelas_id.exists' =>
                    'Kelas yang dipilih tidak valid.',

                'isi_materi.required' =>
                    'Isi materi harus diisi.',

                'gambar.mimes' =>
                    'Gambar harus berformat PNG, JPG, atau JPEG.',

                'gambar.max' =>
                    'Ukuran gambar maksimal 2 MB.',

                'audio.mimes' =>
                    'Audio harus berformat MP3, AAC, WAV, atau OGG.',
            ]
        );

        // Menyiapkan data yang akan disimpan ke database
        $data = [
            'nama_materi' => $request->nama_materi,
            'isi_materi' => $request->isi_materi,

            // Awalnya gambar dan audio dikosongkan
            'gambar' => null,
            'audio' => null,

            'kategori_id' => $request->kategori_id,
            'kelas_id' => $request->kelas_id,
        ];

        // Jika user mengupload gambar
        if ($request->hasFile('gambar')) {

            // Menyimpan gambar ke storage/app/public/materi
            // dan menyimpan path file ke database
            $data['gambar'] = $request->file('gambar')
                ->store('materi', 'public');
        }

        // Jika user mengupload audio
        if ($request->hasFile('audio')) {

            // Menyimpan audio ke storage/app/public/audio
            $data['audio'] = $request->file('audio')
                ->store('audio', 'public');
        }

        // Menyimpan data materi ke database
        Materi::create($data);

        // Kembali ke halaman daftar materi
        // dengan pesan berhasil
        return redirect()
            ->route('materi.index')
            ->with('success', 'Data berhasil ditambahkan');
    }


    // =========================================================
    // MENAMPILKAN DETAIL MATERI
    // =========================================================
    public function show(Materi $materi)
    {
        // Mengambil semua kategori
        $categories = Kategori::get();

        // Menampilkan halaman detail materi
        return view(
            'admin.materi.detail',
            compact('materi', 'categories')
        );
    }


    // =========================================================
    // MENAMPILKAN FORM EDIT MATERI
    // =========================================================
    public function edit(Materi $materi)
    {
        // Mengambil semua kategori
        $kategori = Kategori::get();

        // Mengambil semua kelas
        $kelas = Kelas::get();

        // Menampilkan halaman edit
        // dan mengirim data materi, kategori, serta kelas
        return view(
            'admin.materi.edit',
            compact('materi', 'kategori', 'kelas')
        );
    }


    // =========================================================
    // MEMPERBARUI DATA MATERI
    // =========================================================
    public function update(Request $request, Materi $materi)
    {
        // Validasi data yang akan diperbarui
        $request->validate(
            [
                'nama_materi' => [
                    'required',
                    'string',
                    'max:25',
                    'regex:/^[A-Za-z0-9 ]+$/',
                ],

                'kategori_id' => [
                    'required',
                    'exists:kategoris,id',
                ],

                'kelas_id' => [
                    'required',
                    'exists:kelas,id',
                ],

                'isi_materi' => [
                    'required',
                    'string',
                ],

                'gambar' => [
                    'nullable',
                    'mimes:png,jpg,jpeg',
                    'max:2048',
                ],

                'audio' => [
                    'nullable',
                    'mimes:mp3,aac,wav,ogg',
                ],
            ],

            // Pesan error validasi
            [
                'nama_materi.required' =>
                    'Nama materi harus diisi.',

                'nama_materi.max' =>
                    'Nama materi tidak boleh lebih dari 25 karakter.',

                'nama_materi.regex' =>
                    'Nama materi hanya boleh menggunakan huruf, angka, dan spasi.',

                'kategori_id.required' =>
                    'Kategori harus diisi.',

                'kategori_id.exists' =>
                    'Kategori yang dipilih tidak valid.',

                'kelas_id.required' =>
                    'Kelas harus diisi.',

                'kelas_id.exists' =>
                    'Kelas yang dipilih tidak valid.',

                'isi_materi.required' =>
                    'Isi materi harus diisi.',

                'gambar.mimes' =>
                    'Gambar harus berformat PNG, JPG, atau JPEG.',

                'gambar.max' =>
                    'Ukuran gambar maksimal 2 MB.',

                'audio.mimes' =>
                    'Audio harus berformat MP3, AAC, WAV, atau OGG.',
            ]
        );

        // Menyiapkan data yang akan diperbarui
        $data = [
            'nama_materi' => $request->nama_materi,
            'isi_materi' => $request->isi_materi,
            'kategori_id' => $request->kategori_id,
            'kelas_id' => $request->kelas_id,
        ];

        // Jika ada gambar baru yang diupload
        if ($request->hasFile('gambar')) {

            // Jika gambar lama masih ada,
            // hapus gambar lama dari storage
            if (
                $materi->gambar &&
                Storage::disk('public')->exists($materi->gambar)
            ) {
                Storage::disk('public')->delete($materi->gambar);
            }

            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')
                ->store('materi', 'public');
        }

        // Jika ada audio baru yang diupload
        if ($request->hasFile('audio')) {

            // Hapus audio lama jika masih ada
            if (
                $materi->audio &&
                Storage::disk('public')->exists($materi->audio)
            ) {
                Storage::disk('public')->delete($materi->audio);
            }

            // Simpan audio baru
            $data['audio'] = $request->file('audio')
                ->store('audio', 'public');
        }

        // Memperbarui data materi di database
        $materi->update($data);

        // Kembali ke halaman daftar materi
        return redirect()
            ->route('materi.index')
            ->with('success', 'Update data berhasil');
    }


    // =========================================================
    // MENGHAPUS DATA MATERI
    // =========================================================
    public function destroy(Materi $materi)
    {
        // Jika gambar materi masih ada,
        // hapus file gambar dari storage
        if (
            $materi->gambar &&
            Storage::disk('public')->exists($materi->gambar)
        ) {
            Storage::disk('public')->delete($materi->gambar);
        }

        // Jika audio materi masih ada,
        // hapus file audio dari storage
        if (
            $materi->audio &&
            Storage::disk('public')->exists($materi->audio)
        ) {
            Storage::disk('public')->delete($materi->audio);
        }

        // Menghapus data materi dari database
        $materi->delete();

        // Kembali ke halaman daftar materi
        return redirect()
            ->route('materi.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function listMateri($konten, $kelas, $kategori_id) {

        $kategori = Kategori::findOrFail($kategori_id);

        $materis = $kategori->materi;
        dd($konten, $kelas, $kategori, $materis);
    }
}