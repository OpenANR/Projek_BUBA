<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kategori;
use App\Models\Quis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuisController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR KUIS ADMIN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $quis = Quis::with(['kelas', 'kategori'])
            ->orderByDesc('id')
            ->get();

        return view('admin.kuis.index', compact('quis'));
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH KUIS
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.kuis.add', compact('kelas', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'kategori_id' => 'required|exists:kategoris,id',

            'soal' => 'required|array|min:1',
            'soal.*.pertanyaan' => [
                'required',
                'string',
                'max:1000',
                'regex:/^[A-Za-z0-9\s?=+\-!.,:;()×÷x]+$/u',
            ],

            'soal.*.pilihan_a' => 'required|string',
            'soal.*.pilihan_b' => 'required|string',
            'soal.*.pilihan_c' => 'required|string',
            'soal.*.pilihan_d' => 'required|string',
            'soal.*.jawaban' => 'required|in:A,B,C,D',

            'soal.*.gambar' => 'nullable|array',
            'soal.*.gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            'soal.*.audio_pertanyaan' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'soal.*.audio_pilihan_a' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'soal.*.audio_pilihan_b' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'soal.*.audio_pilihan_c' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'soal.*.audio_pilihan_d' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
        ]);

        $this->validasiKategori(
            $request->kelas_id,
            $request->kategori_id
        );

        DB::transaction(function () use ($request) {
            foreach ($request->input('soal', []) as $index => $soal) {
                $this->simpanSoal(
                    $request,
                    $index,
                    $soal,
                    $request->kelas_id,
                    $request->kategori_id
                );
            }
        });

        return redirect()->route('kuis.index')
            ->with('success', 'Kuis berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL KUIS ADMIN
    |--------------------------------------------------------------------------
    */

    public function show(Quis $quis)
    {
        $quis->load(['kelas', 'kategori']);

        return view('admin.kuis.detail', compact('quis'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT KUIS
    |--------------------------------------------------------------------------
    */

    public function edit($kodeKuis)
    {
        $kuisPertama = Quis::where('kode_kuis', $kodeKuis)
            ->firstOrFail();

        // Ambil semua soal dalam kelas dan kategori yang sama.
        $quis = Quis::where('kelas_id', $kuisPertama->kelas_id)
            ->where('kategori_id', $kuisPertama->kategori_id)
            ->orderBy('id')
            ->get();

        $kelas = Kelas::orderBy('nama_kelas')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.kuis.edit', compact(
            'quis',
            'kelas',
            'kategoris'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE KUIS
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $kodeKuis)
    {
        $kuisPertama = Quis::where('kode_kuis', $kodeKuis)
            ->firstOrFail();

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'kategori_id' => 'required|exists:kategoris,id',

            'soal' => 'required|array|min:1',
            'soal.*.id' => 'nullable|integer',

            'soal.*.pertanyaan' => [
                'required',
                'string',
                'max:1000',
                'regex:/^[A-Za-z0-9\s?=+\-!.,:;()×÷x]+$/u',
            ],

            'soal.*.pilihan_a' => 'required|string',
            'soal.*.pilihan_b' => 'required|string',
            'soal.*.pilihan_c' => 'required|string',
            'soal.*.pilihan_d' => 'required|string',
            'soal.*.jawaban' => 'required|in:A,B,C,D',

            'soal.*.gambar' => 'nullable|array',
            'soal.*.gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            'soal.*.audio_pertanyaan' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'soal.*.audio_pilihan_a' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'soal.*.audio_pilihan_b' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'soal.*.audio_pilihan_c' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'soal.*.audio_pilihan_d' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',

            'hapus_soal' => 'nullable|array',
            'hapus_soal.*' => 'integer',
        ]);

        $this->validasiKategori(
            $request->kelas_id,
            $request->kategori_id
        );

        $kelasLama = $kuisPertama->kelas_id;
        $kategoriLama = $kuisPertama->kategori_id;

        $daftarKuisLama = Quis::where('kelas_id', $kelasLama)
            ->where('kategori_id', $kategoriLama)
            ->get();

        $idKuisLama = $daftarKuisLama->pluck('id')->toArray();

        // Pastikan ID soal berasal dari kelompok yang sedang diedit.
        foreach ($request->input('soal', []) as $soal) {
            if (
                !empty($soal['id']) &&
                !in_array((int) $soal['id'], $idKuisLama, true)
            ) {
                abort(404);
            }
        }

        foreach ($request->input('hapus_soal', []) as $soalId) {
            if (!in_array((int) $soalId, $idKuisLama, true)) {
                abort(404);
            }
        }

        // Menampung file lama yang akan dihapus setelah transaksi berhasil.
        $fileYangDihapus = [];

        DB::transaction(function () use (
            $request,
            $idKuisLama,
            &$fileYangDihapus
        ) {
            // Hapus soal yang dipilih.
            foreach ($request->input('hapus_soal', []) as $soalId) {
                $soalHapus = Quis::whereIn('id', $idKuisLama)
                    ->where('id', $soalId)
                    ->first();

                if ($soalHapus) {
                    $fileYangDihapus = array_merge(
                        $fileYangDihapus,
                        $this->daftarFileKuis($soalHapus)
                    );

                    $soalHapus->delete();
                }
            }

            // Perbarui soal lama atau tambahkan soal baru.
            foreach ($request->input('soal', []) as $index => $soal) {
                $soalLama = null;

                if (!empty($soal['id'])) {
                    $soalLama = Quis::whereIn('id', $idKuisLama)
                        ->where('id', $soal['id'])
                        ->firstOrFail();
                }

                // Catat file lama yang diganti.
                if ($soalLama) {
                    $fileYangDihapus = array_merge(
                        $fileYangDihapus,
                        $this->fileYangDiganti(
                            $request,
                            $index,
                            $soalLama
                        )
                    );
                }

                $this->simpanSoal(
                    $request,
                    $index,
                    $soal,
                    $request->kelas_id,
                    $request->kategori_id,
                    $soalLama
                );
            }
        });

        // Hapus file lama setelah transaksi database berhasil.
        foreach (array_unique($fileYangDihapus) as $file) {
            Storage::disk('public')->delete($file);
        }

        return redirect()->route('kuis.index')
            ->with('success', 'Kuis berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS SATU KUIS
    |--------------------------------------------------------------------------
    */

    public function destroy(Quis $quis)
    {
        $file = $this->daftarFileKuis($quis);

        $quis->delete();

        foreach ($file as $path) {
            Storage::disk('public')->delete($path);
        }

        return redirect()->route('kuis.index')
            ->with('success', 'Kuis berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR KUIS ANAK
    |--------------------------------------------------------------------------
    */

    public function listKuis($konten, Kelas $kelas, Kategori $kategori)
    {
        abort_if((int) $kategori->kelas_id !== (int) $kelas->id, 404);

        $quis = Quis::where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->orderBy('id')
            ->get();

        return view('siswa.quis', compact(
            'konten',
            'kelas',
            'kategori',
            'quis'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | MENAMPILKAN SOAL KUIS ANAK
    |--------------------------------------------------------------------------
    */

    public function showKuis(
        $konten,
        Kelas $kelas,
        Kategori $kategori,
        $kuis
    ) {
        abort_if((int) $kategori->kelas_id !== (int) $kelas->id, 404);

        // Ambil kuis yang dipilih anak.
        $kuisDipilih = Quis::where('kode_kuis', $kuis)
            ->where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->firstOrFail();

        // Ambil semua soal dalam kategori yang sama.
        $quis = Quis::where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->orderBy('id')
            ->get();

        // Tentukan posisi soal yang dipilih.
        $indexAwal = $quis->search(function ($item) use ($kuisDipilih) {
            return (int) $item->id === (int) $kuisDipilih->id;
        });

        if ($indexAwal === false) {
            abort(404);
        }

        return view('siswa.detail-quis', compact(
            'konten',
            'kelas',
            'kategori',
            'quis',
            'kuisDipilih',
            'indexAwal'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER SIMPAN SOAL
    |--------------------------------------------------------------------------
    */

    private function simpanSoal(
        Request $request,
        $index,
        array $soal,
        $kelasId,
        $kategoriId,
        ?Quis $quisLama = null
    ) {
        $data = [
            'kelas_id' => $kelasId,
            'kategori_id' => $kategoriId,
            'pertanyaan' => $soal['pertanyaan'],
            'pilihan_a' => $soal['pilihan_a'],
            'pilihan_b' => $soal['pilihan_b'],
            'pilihan_c' => $soal['pilihan_c'],
            'pilihan_d' => $soal['pilihan_d'],
            'jawaban' => $soal['jawaban'],
        ];

        // Simpan gambar baru.
        $gambarBaru = $request->file("soal.$index.gambar");

        if ($gambarBaru) {
            $gambar = [];

            foreach ($gambarBaru as $file) {
                $gambar[] = $file->store('quis/gambar', 'public');
            }

            $data['gambar'] = $gambar;
        } elseif (!$quisLama) {
            $data['gambar'] = [];
        }

        // Simpan audio pertanyaan dan pilihan.
        $audioFields = [
            'audio_pertanyaan',
            'audio_pilihan_a',
            'audio_pilihan_b',
            'audio_pilihan_c',
            'audio_pilihan_d',
        ];

        foreach ($audioFields as $field) {
            $file = $request->file("soal.$index.$field");

            if ($file) {
                $data[$field] = $file->store('quis/audio', 'public');
            }
        }

        if ($quisLama) {
            $quisLama->update($data);
        } else {
            Quis::create($data);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | FILE LAMA YANG AKAN DIGANTI
    |--------------------------------------------------------------------------
    */

    private function fileYangDiganti(
        Request $request,
        $index,
        Quis $quisLama
    ) {
        $file = [];

        // Gambar lama diganti jika ada gambar baru.
        if ($request->hasFile("soal.$index.gambar")) {
            $file = array_merge(
                $file,
                $this->ambilDaftarGambar($quisLama->gambar)
            );
        }

        // Audio lama diganti jika ada audio baru.
        $audioFields = [
            'audio_pertanyaan',
            'audio_pilihan_a',
            'audio_pilihan_b',
            'audio_pilihan_c',
            'audio_pilihan_d',
        ];

        foreach ($audioFields as $field) {
            if (
                $request->hasFile("soal.$index.$field") &&
                $quisLama->$field
            ) {
                $file[] = $quisLama->$field;
            }
        }

        return $file;
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI KATEGORI
    |--------------------------------------------------------------------------
    */

    private function validasiKategori($kelasId, $kategoriId)
    {
        $sesuai = Kategori::where('id', $kategoriId)
            ->where('kelas_id', $kelasId)
            ->exists();

        if (!$sesuai) {
            abort(422, 'Kategori tidak sesuai dengan kelas.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER GAMBAR
    |--------------------------------------------------------------------------
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

        return is_array($gambar) ? array_filter($gambar) : [];
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR SELURUH FILE KUIS
    |--------------------------------------------------------------------------
    */

    private function daftarFileKuis(Quis $quis)
    {
        $file = $this->ambilDaftarGambar($quis->gambar);

        foreach ([
            'audio_pertanyaan',
            'audio_pilihan_a',
            'audio_pilihan_b',
            'audio_pilihan_c',
            'audio_pilihan_d',
        ] as $field) {
            if ($quis->$field) {
                $file[] = $quis->$field;
            }
        }

        return $file;
    }
}
