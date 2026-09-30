<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Kelas;
use App\Models\Kategori;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index () {
        $total_materi = Materi::count();
        return view('admin.dashboard', compact(['total_materi']));
    }
}
