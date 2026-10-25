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
    | DAFTAR PAKET KUIS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $paketKuis = DB::table('paket_kuis')
            ->join('kelas', 'paket_kuis.kelas_id', '=', 'kelas.id')
            ->join('kategoris', 'paket_kuis.kategori_id', '=', 'kategoris.id')
            ->leftJoin('quis', 'paket_kuis.id', '=', 'quis.paket_kuis_id')
            ->select(
                'paket_kuis.*',
                'kelas.nama_kelas',
                'kategoris.nama_kategori',
                DB::raw('COUNT(quis.id) as jumlah_pertanyaan')
            )
            ->groupBy(
                'paket_kuis.id',
                'paket_kuis.nama_kuis',
                'paket_kuis.kelas_id',
                'paket_kuis.kategori_id',
                'paket_kuis.created_at',
                'paket_kuis.updated_at',
                'kelas.nama_kelas',
                'kategoris.nama_kategori'
            )
            ->orderByDesc('paket_kuis.id')
            ->get();

        return view('admin.kuis.index', compact('paketKuis'));
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH PAKET DAN SOAL
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
            'nama_kuis' => 'required|string|max:255',
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

        $this->validasiKategori($request->kelas_id, $request->kategori_id);

        DB::transaction(function () use ($request) {
            $paketId = DB::table('paket_kuis')->insertGetId([
                'nama_kuis' => $request->nama_kuis,
                'kelas_id' => $request->kelas_id,
                'kategori_id' => $request->kategori_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($request->input('soal', []) as $index => $soal) {
                $this->simpanSoal(
                    $request,
                    $index,
                    $soal,
                    $paketId,
                    $request->kelas_id,
                    $request->kategori_id
                );
            }
        });

        return redirect()->route('kuis.index')
            ->with('success', 'Paket kuis beserta soal berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PAKET DAN SOAL
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $paket = DB::table('paket_kuis')
            ->join('kelas', 'paket_kuis.kelas_id', '=', 'kelas.id')
            ->join('kategoris', 'paket_kuis.kategori_id', '=', 'kategoris.id')
            ->select(
                'paket_kuis.*',
                'kelas.nama_kelas',
                'kategoris.nama_kategori'
            )
            ->where('paket_kuis.id', $id)
            ->first();

        abort_if(!$paket, 404);

        $quis = Quis::where('paket_kuis_id', $id)
            ->orderBy('id')
            ->get();

        return view('admin.kuis.detail', compact('paket', 'quis'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PAKET DAN SOAL
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $paket = DB::table('paket_kuis')->where('id', $id)->first();

        abort_if(!$paket, 404);

        $kelas = Kelas::orderBy('nama_kelas')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        $quis = Quis::where('paket_kuis_id', $id)
            ->orderBy('id')
            ->get();

        return view('admin.kuis.edit', compact(
            'paket',
            'kelas',
            'kategoris',
            'quis'
        ));
    }

    public function update(Request $request, $id)
    {
        $paket = DB::table('paket_kuis')->where('id', $id)->first();

        abort_if(!$paket, 404);

        $request->validate([
            'nama_kuis' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'kategori_id' => 'required|exists:kategoris,id',

            'soal' => 'nullable|array',
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

        $this->validasiKategori($request->kelas_id, $request->kategori_id);

        $soalLama = Quis::where('paket_kuis_id', $id)->get();

        if ($soalLama->isNotEmpty() &&
            ($paket->kelas_id != $request->kelas_id ||
             $paket->kategori_id != $request->kategori_id)) {
            return back()->withInput()->withErrors([
                'kelas_id' => 'Kelas dan kategori tidak dapat diubah karena paket sudah memiliki soal.',
            ]);
        }

        DB::transaction(function () use ($request, $id) {
            DB::table('paket_kuis')->where('id', $id)->update([
                'nama_kuis' => $request->nama_kuis,
                'kelas_id' => $request->kelas_id,
                'kategori_id' => $request->kategori_id,
                'updated_at' => now(),
            ]);

            foreach ($request->input('hapus_soal', []) as $soalId) {
                $soalHapus = Quis::where('paket_kuis_id', $id)
                    ->where('id', $soalId)
                    ->first();

                if ($soalHapus) {
                    $this->hapusFileKuis($soalHapus);
                    $soalHapus->delete();
                }
            }

            foreach ($request->input('soal', []) as $index => $soal) {
                $soalLama = null;

                if (!empty($soal['id'])) {
                    $soalLama = Quis::where('paket_kuis_id', $id)
                        ->where('id', $soal['id'])
                        ->first();
                }

                $this->simpanSoal(
                    $request,
                    $index,
                    $soal,
                    $id,
                    $request->kelas_id,
                    $request->kategori_id,
                    $soalLama
                );
            }
        });

        return redirect()->route('kuis.index')
            ->with('success', 'Paket kuis berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS PAKET BESERTA SOAL
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $paket = DB::table('paket_kuis')->where('id', $id)->first();

        abort_if(!$paket, 404);

        DB::transaction(function () use ($id) {
            $quis = Quis::where('paket_kuis_id', $id)->get();

            foreach ($quis as $soal) {
                $this->hapusFileKuis($soal);
                $soal->delete();
            }

            DB::table('paket_kuis')->where('id', $id)->delete();
        });

        return redirect()->route('kuis.index')
            ->with('success', 'Paket kuis beserta seluruh soalnya berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | KUIS ANAK
    |--------------------------------------------------------------------------
    */

    public function listKuis($konten, Kelas $kelas, Kategori $kategori)
    {
        abort_if($kategori->kelas_id != $kelas->id, 404);

        $paketKuis = DB::table('paket_kuis')
            ->leftJoin('quis', 'paket_kuis.id', '=', 'quis.paket_kuis_id')
            ->where('paket_kuis.kelas_id', $kelas->id)
            ->where('paket_kuis.kategori_id', $kategori->id)
            ->select(
                'paket_kuis.*',
                DB::raw('COUNT(quis.id) as jumlah_pertanyaan')
            )
            ->groupBy(
                'paket_kuis.id',
                'paket_kuis.nama_kuis',
                'paket_kuis.kelas_id',
                'paket_kuis.kategori_id',
                'paket_kuis.created_at',
                'paket_kuis.updated_at'
            )
            ->orderBy('paket_kuis.id')
            ->get();

        return view('siswa.quis', compact(
            'konten',
            'kelas',
            'kategori',
            'paketKuis'
        ));
    }

    public function showKuis($konten, Kelas $kelas, Kategori $kategori, $kuis)
    {
        abort_if($kategori->kelas_id != $kelas->id, 404);

        $paket = DB::table('paket_kuis')
            ->where('id', $kuis)
            ->where('kelas_id', $kelas->id)
            ->where('kategori_id', $kategori->id)
            ->first();

        abort_if(!$paket, 404);

        $quis = Quis::where('paket_kuis_id', $paket->id)
            ->inRandomOrder()
            ->get();

        abort_if($quis->isEmpty(), 404, 'Paket kuis belum memiliki soal.');

        return view('siswa.detail-quis', compact(
            'konten',
            'kelas',
            'kategori',
            'paket',
            'quis'
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
        $paketId,
        $kelasId,
        $kategoriId,
        ?Quis $quisLama = null
    ) {
        $data = [
            'paket_kuis_id' => $paketId,
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
            if ($quisLama) {
                foreach ($this->ambilDaftarGambar($quisLama->gambar) as $file) {
                    Storage::disk('public')->delete($file);
                }
            }

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
                if ($quisLama && $quisLama->$field) {
                    Storage::disk('public')->delete($quisLama->$field);
                }

                $data[$field] = $file->store('quis/audio', 'public');
            }
        }

        if ($quisLama) {
            $quisLama->update($data);
        } else {
            Quis::create($data);
        }
    }

    private function validasiKategori($kelasId, $kategoriId)
    {
        $sesuai = Kategori::where('id', $kategoriId)
            ->where('kelas_id', $kelasId)
            ->exists();

        if (!$sesuai) {
            abort(422, 'Kategori tidak sesuai dengan kelas.');
        }
    }

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

    private function hapusFileKuis(Quis $quis)
    {
        foreach ($this->ambilDaftarGambar($quis->gambar) as $file) {
            Storage::disk('public')->delete($file);
        }

        foreach ([
            'audio_pertanyaan',
            'audio_pilihan_a',
            'audio_pilihan_b',
            'audio_pilihan_c',
            'audio_pilihan_d',
        ] as $field) {
            if ($quis->$field) {
                Storage::disk('public')->delete($quis->$field);
            }
        }
    }
}
