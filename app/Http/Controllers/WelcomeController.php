<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function splash() {
        
        $siswa = Auth::user();
        $dataKelas = $siswa->kelas;
        // dd($dataKelas);
        return view('siswa.splash', compact('dataKelas'));
    }

    public function content() {
        return view('siswa.konten');
    }
}
