<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $materi = Materi::all();
        $kategori = Kategori::get();
        $kelas = Kelas::get();

        if ($request->wantsJson()) {
            return response()->json(compact('materi', 'kategori', 'kelas'));
        }

        return view(
            'admin.materi.index',
            compact('materi', 'kategori', 'kelas')
        );
    }

    public function add()
    {
        $kategori = Kategori::get();
        $kelas = Kelas::get();

        return view(
            'admin.materi.add',
            compact('kategori', 'kelas')
        );
    }

    public function store(Request $request)
    {
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
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show(Materi $materi)
    {
        $categories = Kategori::get();

        return view(
            'admin.materi.detail',
            compact('materi', 'categories')
        );
    }

    public function edit(Materi $materi)
    {
        $kategori = Kategori::get();
        $kelas = Kelas::get();

        return view(
            'admin.materi.edit',
            compact('materi', 'kategori', 'kelas')
        );
    }

    public function update(Request $request, Materi $materi)
    {
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

        $data = [
            'nama_materi' => $request->nama_materi,
            'isi_materi' => $request->isi_materi,
            'kategori_id' => $request->kategori_id,
            'kelas_id' => $request->kelas_id,
        ];

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
            ->with('success', 'Update data berhasil');
    }

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
            ->with('success', 'Data berhasil dihapus');
    }
}