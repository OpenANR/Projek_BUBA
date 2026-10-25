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

        return view('admin.kuis.add', compact('kelas', 'kategoris'));
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
                'max:1000',
                'regex:/^[A-Za-z0-9\s?=+\-!.,:;()×÷x]+$/u',
            ],

            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',

            'jawaban' => 'required|in:A,B,C,D',

            // Gambar
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            // Audio
            'audio_pertanyaan' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'audio_pilihan_a' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'audio_pilihan_b' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'audio_pilihan_c' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'audio_pilihan_d' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',

        ], [
            'pertanyaan.required' => 'Pertanyaan harus diisi.',
            'pertanyaan.max' => 'Pertanyaan maksimal 1000 karakter.',
            'pertanyaan.regex' => 'Pertanyaan hanya boleh menggunakan huruf, angka, spasi, simbol matematika (+, -, =, ×, ÷, x), dan tanda baca (?, !, ., , , :, ;, (, )).',

            'gambar.*.image' => 'File gambar harus berupa gambar.',
            'gambar.*.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.*.max' => 'Ukuran setiap gambar maksimal 2 MB.',

            'audio_pertanyaan.mimes' => 'Audio pertanyaan harus MP3, WAV, atau OGG.',
            'audio_pilihan_a.mimes' => 'Audio pilihan A harus MP3, WAV, atau OGG.',
            'audio_pilihan_b.mimes' => 'Audio pilihan B harus MP3, WAV, atau OGG.',
            'audio_pilihan_c.mimes' => 'Audio pilihan C harus MP3, WAV, atau OGG.',
            'audio_pilihan_d.mimes' => 'Audio pilihan D harus MP3, WAV, atau OGG.',

            'audio_pertanyaan.max' => 'Ukuran audio pertanyaan maksimal 10 MB.',
            'audio_pilihan_a.max' => 'Ukuran audio pilihan A maksimal 10 MB.',
            'audio_pilihan_b.max' => 'Ukuran audio pilihan B maksimal 10 MB.',
            'audio_pilihan_c.max' => 'Ukuran audio pilihan C maksimal 10 MB.',
            'audio_pilihan_d.max' => 'Ukuran audio pilihan D maksimal 10 MB.',
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
                    'kategori_id' => 'Kategori yang dipilih tidak sesuai dengan kelas.',
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
                    'pertanyaan' => 'Pertanyaan tersebut sudah ada di kelas yang dipilih. Silakan gunakan pertanyaan lain.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Menyiapkan data soal
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
                $gambarPaths[] = $gambar->store('quis/gambar', 'public');
            }
        }

        $data['gambar'] = $gambarPaths;

        /*
        |--------------------------------------------------------------------------
        | Upload lima audio
        |--------------------------------------------------------------------------
        */
        $daftarAudio = [
            'audio_pertanyaan',
            'audio_pilihan_a',
            'audio_pilihan_b',
            'audio_pilihan_c',
            'audio_pilihan_d',
        ];

        foreach ($daftarAudio as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)
                    ->store('quis/audio', 'public');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan soal
        |--------------------------------------------------------------------------
        */
        Quis::create($data);

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Soal kuis berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail soal
     */
    public function show(Quis $quis)
    {
        $quis->load(['kelas', 'kategori']);

        return view('admin.kuis.detail', compact('quis'));
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
            compact('quis', 'kelas', 'kategoris')
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
                'max:1000',
                'regex:/^[A-Za-z0-9\s?=+\-!.,:;()×÷x]+$/u',
            ],

            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',

            'jawaban' => 'required|in:A,B,C,D',

            // Gambar
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            // Audio
            'audio_pertanyaan' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'audio_pilihan_a' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'audio_pilihan_b' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'audio_pilihan_c' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'audio_pilihan_d' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',

        ], [
            'pertanyaan.required' => 'Pertanyaan harus diisi.',
            'pertanyaan.max' => 'Pertanyaan maksimal 1000 karakter.',
            'pertanyaan.regex' => 'Pertanyaan hanya boleh menggunakan huruf, angka, spasi, simbol matematika (+, -, =, ×, ÷, x), dan tanda baca (?, !, ., , , :, ;, (, )).',

            'gambar.*.image' => 'File gambar harus berupa gambar.',
            'gambar.*.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.*.max' => 'Ukuran setiap gambar maksimal 2 MB.',

            'audio_pertanyaan.mimes' => 'Audio pertanyaan harus MP3, WAV, atau OGG.',
            'audio_pilihan_a.mimes' => 'Audio pilihan A harus MP3, WAV, atau OGG.',
            'audio_pilihan_b.mimes' => 'Audio pilihan B harus MP3, WAV, atau OGG.',
            'audio_pilihan_c.mimes' => 'Audio pilihan C harus MP3, WAV, atau OGG.',
            'audio_pilihan_d.mimes' => 'Audio pilihan D harus MP3, WAV, atau OGG.',

            'audio_pertanyaan.max' => 'Ukuran audio pertanyaan maksimal 10 MB.',
            'audio_pilihan_a.max' => 'Ukuran audio pilihan A maksimal 10 MB.',
            'audio_pilihan_b.max' => 'Ukuran audio pilihan B maksimal 10 MB.',
            'audio_pilihan_c.max' => 'Ukuran audio pilihan C maksimal 10 MB.',
            'audio_pilihan_d.max' => 'Ukuran audio pilihan D maksimal 10 MB.',
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
                    'kategori_id' => 'Kategori yang dipilih tidak sesuai dengan kelas.',
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
                    'pertanyaan' => 'Pertanyaan tersebut sudah ada di kelas yang dipilih. Silakan gunakan pertanyaan lain.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Data soal yang diperbarui
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
        | Ganti gambar jika ada gambar baru
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('gambar')) {
            $gambarLama = $this->ambilDaftarGambar($quis->gambar);

            foreach ($gambarLama as $file) {
                Storage::disk('public')->delete($file);
            }

            $gambarPaths = [];

            foreach ($request->file('gambar') as $gambar) {
                $gambarPaths[] = $gambar->store('quis/gambar', 'public');
            }

            $data['gambar'] = $gambarPaths;
        }

        /*
        |--------------------------------------------------------------------------
        | Ganti audio jika ada file audio baru
        |--------------------------------------------------------------------------
        */
        $daftarAudio = [
            'audio_pertanyaan',
            'audio_pilihan_a',
            'audio_pilihan_b',
            'audio_pilihan_c',
            'audio_pilihan_d',
        ];

        foreach ($daftarAudio as $field) {
            if ($request->hasFile($field)) {

                if ($quis->$field) {
                    Storage::disk('public')->delete($quis->$field);
                }

                $data[$field] = $request->file($field)
                    ->store('quis/audio', 'public');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Update soal
        |--------------------------------------------------------------------------
        */
        $quis->update($data);

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Soal kuis berhasil diperbarui.');
    }

    /**
     * Menghapus soal
     */
    public function destroy(Quis $quis)
    {
        // Hapus semua gambar
        $gambar = $this->ambilDaftarGambar($quis->gambar);

        foreach ($gambar as $file) {
            Storage::disk('public')->delete($file);
        }

        // Hapus semua audio
        $daftarAudio = [
            'audio_pertanyaan',
            'audio_pilihan_a',
            'audio_pilihan_b',
            'audio_pilihan_c',
            'audio_pilihan_d',
        ];

        foreach ($daftarAudio as $field) {
            if ($quis->$field) {
                Storage::disk('public')->delete($quis->$field);
            }
        }

        // Hapus data soal
        $quis->delete();

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Soal kuis berhasil dihapus.');
    }

    /**
     * Mengubah data gambar menjadi array
     */
    private function ambilDaftarGambar($gambar)
    {
        if (empty($gambar)) {
            return [];
        }

        if (is_string($gambar)) {
            $decoded = json_decode($gambar, true);
            $gambar = is_array($decoded) ? $decoded : [$gambar];
        }

        if (!is_array($gambar)) {
            return [];
        }

        return array_filter($gambar);
    }

    /**
     * Menampilkan soal untuk anak
     */
    public function listKuis($konten, $kelas, $kategori)
    {
        $dataKelas = Kelas::findOrFail($kelas);
        $dataKategori = Kategori::findOrFail($kategori);

        // Memastikan kategori sesuai dengan kelas
        if ((int) $dataKategori->kelas_id !== (int) $dataKelas->id) {
            abort(404, 'Kategori tidak sesuai dengan kelas.');
        }

        // Mengambil soal yang telah dibuat admin
        $quis = Quis::query()
            ->where('kelas_id', $dataKelas->id)
            ->where('kategori_id', $dataKategori->id)
            ->inRandomOrder()
            ->get();

        return view('siswa.quis', [
            'konten' => $konten,
            'quis' => $quis,
            'dataKelas' => $dataKelas,
            'dataKategori' => $dataKategori,
        ]);
    }
}
