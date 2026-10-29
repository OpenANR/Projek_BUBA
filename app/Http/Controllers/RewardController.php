<?php

namespace App\Http\Controllers;

use App\Models\Reward;

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

    // MENGHAPUS DATA REWARD
    public function hapus($id)
    {
        $reward = Reward::findOrFail($id);

        $reward->delete();

        return redirect()
            ->route('reward.index')
            ->with('success', 'Hasil reward anak berhasil dihapus.');
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
