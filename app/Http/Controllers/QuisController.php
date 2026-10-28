<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kategori;
use App\Models\Quis;
use App\Models\Reward;
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

        // Cek soal duplikat dalam satu form.
        $daftarPertanyaan = [];

        foreach ($request->input('soal', []) as $index => $soal) {
            $pertanyaan = mb_strtolower(trim($soal['pertanyaan']));

            if (in_array($pertanyaan, $daftarPertanyaan, true)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        "soal.$index.pertanyaan" =>
                            'Pertanyaan ini duplikat dengan soal lain dalam form.',
                    ]);
            }

            $daftarPertanyaan[] = $pertanyaan;
        }

        // Cek soal yang sudah tersimpan pada kelas dan kategori yang sama.
        foreach ($request->input('soal', []) as $index => $soal) {
            $pertanyaan = mb_strtolower(trim($soal['pertanyaan']));

            $duplikat = Quis::where('kelas_id', $request->kelas_id)
                ->where('kategori_id', $request->kategori_id)
                ->whereRaw('LOWER(TRIM(pertanyaan)) = ?', [$pertanyaan])
                ->exists();

            if ($duplikat) {
                return back()
                    ->withInput()
                    ->withErrors([
                        "soal.$index.pertanyaan" =>
                            'Pertanyaan ini sudah pernah ditambahkan pada kelas dan kategori tersebut.',
                    ]);
            }
        }

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

        // Cek soal duplikat dalam satu form edit.
        $daftarPertanyaan = [];

        foreach ($request->input('soal', []) as $index => $soal) {
            $pertanyaan = mb_strtolower(trim($soal['pertanyaan']));

            if (in_array($pertanyaan, $daftarPertanyaan, true)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        "soal.$index.pertanyaan" =>
                            'Pertanyaan ini duplikat dengan soal lain dalam form.',
                    ]);
            }

            $daftarPertanyaan[] = $pertanyaan;
        }

        // Cek soal yang sudah tersimpan di luar kelompok yang sedang diedit.
        foreach ($request->input('soal', []) as $index => $soal) {
            $pertanyaan = mb_strtolower(trim($soal['pertanyaan']));

            $duplikat = Quis::where('kelas_id', $request->kelas_id)
                ->where('kategori_id', $request->kategori_id)
                ->whereNotIn('id', $idKuisLama)
                ->whereRaw('LOWER(TRIM(pertanyaan)) = ?', [$pertanyaan])
                ->exists();

            if ($duplikat) {
                return back()
                    ->withInput()
                    ->withErrors([
                        "soal.$index.pertanyaan" =>
                            'Pertanyaan ini sudah digunakan pada kelas dan kategori tersebut.',
                    ]);
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
        Request $request,
        $konten,
        Kelas $kelas,
        Kategori $kategori,
        $kuis
    ) {
        abort_if((int) $kategori->kelas_id !== (int) $kelas->id, 404);

        $kuisDipilih = Quis::where('kode_kuis', $kuis)
            ->where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->firstOrFail();

        $sessionKey = 'buba_quis_order_'
            . (auth()->id() ?? session()->getId())
            . '_' . $kelas->id
            . '_' . $kategori->id;

        $semuaIdSoal = Quis::where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->pluck('id')
            ->all();

        if ($request->boolean('ulang')) {
            $urutanId = collect($semuaIdSoal)
                ->shuffle()
                ->values()
                ->all();

            session()->put($sessionKey, $urutanId);

            return redirect()->route('siswa.showKuis', [
                'konten' => $konten,
                'kelas' => $kelas->nama_kelas,
                'kategori' => $kategori->slug,
                'kuis' => $kuisDipilih->kode_kuis,
            ]);
        }

        if (!session()->has($sessionKey)) {
            $urutanId = collect($semuaIdSoal)
                ->shuffle()
                ->values()
                ->all();

            session()->put($sessionKey, $urutanId);
        }

        $urutanId = session()->get($sessionKey, []);

        $urutanId = array_values(
            array_intersect($urutanId, $semuaIdSoal)
        );

        $idBaru = array_values(
            array_diff($semuaIdSoal, $urutanId)
        );

        if (!empty($idBaru)) {
            shuffle($idBaru);
            $urutanId = array_merge($urutanId, $idBaru);
        }

        session()->put($sessionKey, $urutanId);

        $daftarSoal = Quis::whereIn('id', $urutanId)
            ->where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->get()
            ->keyBy('id');

        $quis = collect($urutanId)
            ->map(fn ($id) => $daftarSoal->get($id))
            ->filter()
            ->values();

        $indexAwal = 0;

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
    | MENYIMPAN HASIL KUIS ANAK
    |--------------------------------------------------------------------------
    */

    public function simpanHasil(
        Request $request,
        $konten,
        Kelas $kelas,
        Kategori $kategori,
        $kuis
    ) {
        abort_if((int) $kategori->kelas_id !== (int) $kelas->id, 404);

        // Pastikan kuis yang dipilih memang tersedia.
        $kuisDipilih = Quis::where('kode_kuis', $kuis)
            ->where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->firstOrFail();

        // Validasi jawaban yang dikirim dari halaman pengerjaan.
        $validated = $request->validate([
            'jawaban' => 'required|array|min:1',
            'jawaban.*' => 'required|in:A,B,C,D',
        ]);

        // Ambil urutan soal dari session yang dibuat controller.
        $sessionKey = 'buba_quis_order_'
            . auth()->id()
            . '_' . $kelas->id
            . '_' . $kategori->id;

        $urutanId = session()->get($sessionKey, []);

        if (empty($urutanId)) {
            return response()->json([
                'message' => 'Sesi kuis tidak ditemukan. Silakan mulai kuis kembali.',
            ], 422);
        }

        $jawabanAnak = $validated['jawaban'];

        // Pastikan anak menjawab seluruh soal dalam sesi tersebut.
        $idJawaban = array_map('intval', array_keys($jawabanAnak));
        $idSoalSesi = array_map('intval', $urutanId);

        sort($idJawaban);
        sort($idSoalSesi);

        if ($idJawaban !== $idSoalSesi) {
            return response()->json([
                'message' => 'Data jawaban tidak sesuai dengan soal kuis.',
            ], 422);
        }

        // Ambil soal dari database, bukan mempercayai jawaban benar dari browser.
        $daftarSoal = Quis::whereIn('id', $urutanId)
            ->where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->get()
            ->keyBy('id');

        if ($daftarSoal->count() !== count($urutanId)) {
            return response()->json([
                'message' => 'Sebagian soal kuis sudah tidak tersedia.',
            ], 422);
        }

        $benar = 0;

        foreach ($daftarSoal as $id => $soal) {
            if (
                strtoupper($jawabanAnak[$id]) ===
                strtoupper($soal->jawaban)
            ) {
                $benar++;
            }
        }

        $total = $daftarSoal->count();
        $salah = $total - $benar;

        $nilai = $total > 0
            ? (int) round(($benar / $total) * 100)
            : 0;

        // Menghitung bintang berdasarkan nilai.
        if ($nilai >= 90) {
            $jumlahBintang = 5;
        } elseif ($nilai >= 70) {
            $jumlahBintang = 4;
        } elseif ($nilai >= 50) {
            $jumlahBintang = 3;
        } elseif ($nilai >= 20) {
            $jumlahBintang = 2;
        } elseif ($nilai >= 1) {
            $jumlahBintang = 1;
        } else {
            $jumlahBintang = 0;
        }

        // Simpan satu hasil untuk satu sesi pengerjaan kuis.
        $reward = Reward::create([
            'user_id' => auth()->id(),
            'quis_id' => $kuisDipilih->id,
            'jumlah_benar' => $benar,
            'jumlah_salah' => $salah,
            'skor' => $nilai,
            'jumlah_bintang' => $jumlahBintang,
        ]);

        return response()->json([
            'message' => 'Hasil kuis berhasil disimpan.',
            'nilai' => $nilai,
            'benar' => $benar,
            'salah' => $salah,
            'total' => $total,
            'jumlah_bintang' => $jumlahBintang,
        ]);
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

        if ($request->hasFile("soal.$index.gambar")) {
            $file = array_merge(
                $file,
                $this->ambilDaftarGambar($quisLama->gambar)
            );
        }

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
