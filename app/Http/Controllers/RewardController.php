<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RewardController extends Controller
{
    // MENAMPILKAN DATA REWARD
    public function index()
    {
        $rewards = Reward::with([
            'user',
            'quis.kelas',
            'quis.kategori'
        ])
        ->orderByDesc('created_at')
        ->get();

        return view('admin.reward.index', compact('rewards'));
    }

        // MENAMPILKAN HASIL REWARD SISWA
        public function indexSiswa()
    {
        $rewards = Reward::with([
            'quis.kelas',
            'quis.kategori'
        ])
        ->where('user_id', auth()->id())
        ->orderByDesc('created_at')
        ->get();

        $totalKuis = $rewards->count();
        $totalBintang = $rewards->sum('jumlah_bintang');
        $totalReward = $rewards->where('jumlah_bintang', '>', 0)->count();

        $rataRata = $totalKuis > 0
            ? round($rewards->avg('skor'))
            : 0;

        return view('siswa.reward', compact(
            'rewards',
            'totalKuis',
            'totalBintang',
            'totalReward',
            'rataRata'
        ));
    }

    // MENGHAPUS SATU DATA REWARD
    public function hapus($id)
    {
        $reward = Reward::findOrFail($id);
        $reward->delete();

        return redirect()
            ->route('reward.index')
            ->with('success', 'Hasil reward anak berhasil dihapus.');
    }

    // MENGHAPUS REWARD TERPILIH
    public function hapusTerpilih(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|distinct|exists:rewards,id',
        ]);

        Reward::whereIn('id', $validated['ids'])->delete();

        return redirect()
            ->route('reward.index')
            ->with('success', 'Hasil reward yang dipilih berhasil dihapus.');
    }

    // MENGHAPUS SEMUA DATA REWARD
    public function hapusSemua()
    {
        Reward::query()->delete();

        return redirect()
            ->route('reward.index')
            ->with('success', 'Seluruh hasil reward berhasil dihapus.');
    }

    // DOWNLOAD PDF SEMUA HASIL KUIS SISWA
        public function downloadSemuaPdf()
        {
            $rewards = Reward::with([
                'user',
                'quis.kelas',
                'quis.kategori'
            ])
            ->orderByDesc('created_at')
            ->get();

            $pdf = Pdf::loadView('admin.reward.pdf', [
                'rewards' => $rewards,
                'judul' => 'Laporan Seluruh Hasil Kuis Siswa'
            ]);

            return $pdf->setPaper('a4', 'landscape')
                ->download('laporan-hasil-kuis-siswa.pdf');
        }

        // DOWNLOAD PDF SATU HASIL KUIS SISWA
        public function downloadPdf($id)
        {
            $rewards = Reward::with([
                'user',
                'quis.kelas',
                'quis.kategori'
            ])
            ->where('id', $id)
            ->get();

            if ($rewards->isEmpty()) {
                abort(404, 'Data hasil kuis tidak ditemukan.');
            }

            $pdf = Pdf::loadView('admin.reward.pdf', [
                'rewards' => $rewards,
                'judul' => 'Laporan Hasil Kuis Siswa'
            ]);

            return $pdf->setPaper('a4', 'landscape')
                ->download('hasil-kuis-siswa-' . $id . '.pdf');
        }
}
