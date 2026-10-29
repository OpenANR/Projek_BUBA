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

        $fileYangDihapus = [];

        DB::transaction(function () use (
            $request,
            $idKuisLama,
            &$fileYangDihapus
        ) {
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

            foreach ($request->input('soal', []) as $index => $soal) {
                $quisLama = null;

                if (!empty($soal['id'])) {
                    $quisLama = Quis::whereIn('id', $idKuisLama)
                        ->where('id', $soal['id'])
                        ->firstOrFail();

                    $fileYangDihapus = array_merge(
                        $fileYangDihapus,
                        $this->fileYangDiganti(
                            $request,
                            $index,
                            $quisLama
                        )
                    );
                }

                $this->simpanSoal(
                    $request,
                    $index,
                    $soal,
                    $request->kelas_id,
                    $request->kategori_id,
                    $quisLama
                );
            }
        });

        foreach (array_unique($fileYangDihapus) as $file) {
            Storage::disk('public')->delete($file);
        }

        return redirect()->route('kuis.index')
            ->with('success', 'Kuis berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS KUIS
    |--------------------------------------------------------------------------
    */

    public function destroy(Quis $quis)
    {
        foreach ($this->daftarFileKuis($quis) as $file) {
            Storage::disk('public')->delete($file);
        }

        $quis->delete();

        return redirect()->route('kuis.index')
            ->with('success', 'Soal berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | MENGHAPUS SEMUA DATA KUIS
    |--------------------------------------------------------------------------
    */

    public function hapusSemua()
    {
        $semuaQuis = Quis::all();

        $daftarFile = [];

        // Mengumpulkan gambar dan audio seluruh kuis
        foreach ($semuaQuis as $quis) {

            // Gambar kuis
            $gambar = $quis->gambar;

            if (is_array($gambar)) {
                foreach ($gambar as $file) {
                    if (!empty($file)) {
                        $daftarFile[] = $file;
                    }
                }
            }

            // Audio pertanyaan dan audio pilihan
            $kolomAudio = [
                'audio',
                'audio_pertanyaan',
                'audio_pilihan_a',
                'audio_pilihan_b',
                'audio_pilihan_c',
                'audio_pilihan_d',
            ];

            foreach ($kolomAudio as $kolom) {
                if (!empty($quis->$kolom)) {
                    $daftarFile[] = $quis->$kolom;
                }
            }
        }

        // Hapus reward dan kuis dalam satu transaksi
        DB::transaction(function () {
            Reward::query()->delete();
            Quis::query()->delete();
        });

        // Hapus file setelah data database berhasil dihapus
        if (!empty($daftarFile)) {
            Storage::disk('public')->delete(array_unique($daftarFile));
        }

        return redirect()
            ->route('kuis.index')
            ->with('success', 'Seluruh data kuis dan hasil reward berhasil dihapus.');
    }
    /*
    |--------------------------------------------------------------------------
    | HELPER CEK KUIS TERKUNCI
    |--------------------------------------------------------------------------
    */

    private function kuisSudahTerkunci($userId, $kelasId, $kategoriId)
    {
        return Reward::where('user_id', $userId)
            ->where('jumlah_bintang', '>=', 3)
            ->whereHas('quis', function ($query) use ($kelasId, $kategoriId) {
                $query->where('kelas_id', $kelasId)
                    ->where('kategori_id', $kategoriId);
            })
            ->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR KUIS ANAK
    |--------------------------------------------------------------------------
    */

    public function listKuis($konten, Kelas $kelas, Kategori $kategori)
    {
        abort_if(
            (int) $kategori->kelas_id !== (int) $kelas->id,
            404
        );

        $quis = Quis::where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->orderBy('id')
            ->get();

        $kuisTerkunci = $this->kuisSudahTerkunci(
            auth()->id(),
            $kelas->id,
            $kategori->id
        );

        return view('siswa.quis', compact(
            'konten',
            'kelas',
            'kategori',
            'quis',
            'kuisTerkunci'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | MENAMPILKAN KUIS ANAK
    |--------------------------------------------------------------------------
    */

    public function showKuis(
        Request $request,
        $konten,
        Kelas $kelas,
        Kategori $kategori,
        $kuis
    ) {
        abort_if(
            (int) $kategori->kelas_id !== (int) $kelas->id,
            404
        );

        $kuisDipilih = Quis::where('kode_kuis', $kuis)
            ->where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->firstOrFail();

        // Periksa penguncian sebelum memproses permintaan ulang.
        if ($this->kuisSudahTerkunci(
            auth()->id(),
            $kelas->id,
            $kategori->id
        )) {
            return redirect()
                ->route('siswa.kuis', [
                    'konten' => $konten,
                    'kelas' => $kelas->nama_kelas,
                    'kategori' => $kategori->slug,
                ])
                ->with(
                    'error',
                    'Kuis ini sudah selesai karena kamu telah mendapatkan 3 bintang atau lebih! ⭐'
                );
        }

        $sessionKey = 'buba_quis_order_'
            . auth()->id()
            . '_' . $kelas->id
            . '_' . $kategori->id;

        // Jika anak memilih mengulang, buat urutan soal baru.
        if ($request->boolean('ulang')) {
            session()->forget($sessionKey);
        }

        $urutanId = session()->get($sessionKey, []);

        $semuaId = Quis::where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->pluck('id')
            ->toArray();

        if (empty($semuaId)) {
            return redirect()
                ->route('siswa.kuis', [
                    'konten' => $konten,
                    'kelas' => $kelas->nama_kelas,
                    'kategori' => $kategori->slug,
                ])
                ->with('error', 'Belum ada soal untuk kategori ini.');
        }

        if (empty($urutanId)) {
            $urutanId = $semuaId;
            shuffle($urutanId);

            session()->put($sessionKey, $urutanId);
        } else {
            $idBaru = array_values(array_diff($semuaId, $urutanId));

            if (!empty($idBaru)) {
                shuffle($idBaru);
                $urutanId = array_merge($urutanId, $idBaru);
                session()->put($sessionKey, $urutanId);
            }
        }

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
        abort_if(
            (int) $kategori->kelas_id !== (int) $kelas->id,
            404
        );

        $kuisDipilih = Quis::where('kode_kuis', $kuis)
            ->where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->firstOrFail();

        $validated = $request->validate([
            'jawaban' => 'required|array|min:1',
            'jawaban.*' => 'required|in:A,B,C,D',
        ]);

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

        $idJawaban = array_map('intval', array_keys($jawabanAnak));
        $idSoalSesi = array_map('intval', $urutanId);

        sort($idJawaban);
        sort($idSoalSesi);

        if ($idJawaban !== $idSoalSesi) {
            return response()->json([
                'message' => 'Data jawaban tidak sesuai dengan soal kuis.',
            ], 422);
        }

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

        $reward = DB::transaction(function () use (
            $kelas,
            $kategori,
            $kuisDipilih,
            $benar,
            $salah,
            $nilai,
            $jumlahBintang
        ) {
            \App\Models\User::whereKey(auth()->id())
                ->lockForUpdate()
                ->firstOrFail();

            $sudahTerkunci = Reward::where('user_id', auth()->id())
                ->where('jumlah_bintang', '>=', 3)
                ->whereHas('quis', function ($query) use ($kelas, $kategori) {
                    $query->where('kelas_id', $kelas->id)
                        ->where('kategori_id', $kategori->id);
                })
                ->exists();

            if ($sudahTerkunci) {
                return null;
            }

            return Reward::create([
                'user_id' => auth()->id(),
                'quis_id' => $kuisDipilih->id,
                'jumlah_benar' => $benar,
                'jumlah_salah' => $salah,
                'skor' => $nilai,
                'jumlah_bintang' => $jumlahBintang,
            ]);
        });

        if (!$reward) {
            return response()->json([
                'message' => 'Kuis sudah terkunci karena kamu telah mendapatkan minimal 3 bintang! ⭐',
                'terkunci' => true,
            ], 403);
        }

        return response()->json([
            'message' => 'Hasil kuis berhasil disimpan.',
            'nilai' => $nilai,
            'benar' => $benar,
            'salah' => $salah,
            'total' => $total,
            'jumlah_bintang' => $jumlahBintang,
            'terkunci' => $jumlahBintang >= 3,
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
