<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

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
}
