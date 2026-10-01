<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Kelas;
use App\Models\Kategori;
use App\Models\Siswa;
<<<<<<< HEAD
use App\Models\Quis;
=======
>>>>>>> 62312ce (Perbaikan kategori)

class DashboardController extends Controller
{
    public function index () {
        $total_materi = Materi::count();
<<<<<<< HEAD
        $total_kelas = Kelas::count();
        $total_kategori = Kategori::count();
        $total_siswa = Siswa::count();
        $total_kuis = Quis::count();
        return view('admin.dashboard', compact(['total_materi', 'total_kelas', 'total_kategori', 'total_siswa', 'total_kuis']));
=======
        return view('admin.dashboard', compact(['total_materi']));
>>>>>>> 62312ce (Perbaikan kategori)
    }
}
