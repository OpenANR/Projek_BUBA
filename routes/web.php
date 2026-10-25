<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\QuisController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaQuisController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/**
 * ROUTE UNTUK MENENTUKAN JALUR SEBUAH HALAMAN ADMIN DAN SISWA
 * HALAMAN MASIH DALAM TAHAP PENGEMBANGAN
 * 
 * by : Najatif_2026
 */

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::middleware(['auth', 'role:guru'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // RUTE HALAMAN KELAS
    // Route::resource('kelas', KelasController::class)->except(['show']);
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/tambah', [KelasController::class, 'add'])->name('kelas.tambah');
    Route::post('/kelas/kirim', [KelasController::class, 'store'])->name('kelas.kirim');
    Route::get('/kelas/edit/{kelas}', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/edit/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/hapus/{kelas}', [KelasController::class, 'destroy'])->name('kelas.hapus');
    // =================================================

    // RUTE HALAMAN KATEGORI
    Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/tambah', [CategoryController::class, 'add'])->name('kategori.tambah');
    Route::post('/kategori/kirim', [CategoryController::class, 'store'])->name('kategori.kirim');
    Route::get('/kategori/edit/{kategori}', [CategoryController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/edit/{kategori}', [CategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/hapus/{kategori}', [CategoryController::class, 'destroy'])->name('kategori.hapus');
    // =================================================

    // RUTE MATERI
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/tambah', [MateriController::class, 'add'])->name('materi.tambah');
    Route::post('/materi/kirim', [MateriController::class, 'store'])->name('materi.kirim');
    Route::get('/materi/detail/{materi}', [MateriController::class, 'show'])->name('materi.detail');
    Route::get('/materi/edit/{materi}', [MateriController::class, 'edit'])->name('materi.edit');
    Route::put('/materi/update/{materi}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/hapus/{materi}', [MateriController::class, 'destroy'])->name('materi.hapus');
    // =================================================

    // RUTE KUIS
    Route::get('/kuis', [QuisController::class, 'index'])->name('kuis.index');
    Route::get('/kuis/tambah', [QuisController::class, 'create'])->name('kuis.tambah');
    Route::post('/kuis/kirim', [QuisController::class, 'store'])->name('kuis.kirim');
    Route::get('/kuis/detail/{quis}', [QuisController::class, 'show'])->name('kuis.detail');
    Route::get('/kuis/edit/{quis}', [QuisController::class, 'edit'])->name('kuis.edit');
    Route::put('/kuis/update/{quis}', [QuisController::class, 'update'])->name('kuis.update');
    Route::delete('/kuis/hapus/{quis}', [QuisController::class, 'destroy'])->name('kuis.hapus');
    // =================================================

    // RUTE SISWA
    // Route::resource('/siswa', SiswaController::class);
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/tambah', [SiswaController::class, 'create'])->name('siswa.tambah');
    Route::post('/siswa/kirim', [SiswaController::class, 'store'])->name('siswa.kirim');
    Route::get('/siswa/edit/{siswa}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/update/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/hapus/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.hapus');
    // =================================================

    // RUTE REWARD
    Route::get('/reward', function () {
        return view('admin.reward.index');
    })->name('reward.index');
});


Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {

    Route::get('/welcome', function () {
        return view('siswa.splash');
    })->name('splash');

    Route::get('/pengaturan', function () {
        return view('siswa.splash');
    })->name('siswa.pengaturan');

    Route::get('/konten', function () {
        return view('siswa.konten');
    })->name('siswa.konten');

    Route::prefix('{konten}')->group(function () {
        Route::get('/pilih-kelas', [KelasController::class, 'pilihKelas'])->name('siswa.kelas');
        Route::get('/{kelas:nama_kelas}', [CategoryController::class, 'pilihKategori'])->name('siswa.kategori');

        Route::get('/materi-list/{kelas:nama_kelas}/{kategori}', [MateriController::class, 'listMateri'])->name('siswa.materi');
        Route::get('/materi-show/{kelas:nama_kelas}/{kategori}/{materi}', [MateriController::class, 'showMateri'])->name('siswa.showMateri');

        Route::get('/kuis-list/{kelas:nama_kelas}/{kategori:slug}', [QuisController::class, 'listKuis'])->name('siswa.kuis');
        Route::get('/kuis-show/{kelas:nama_kelas}/{kategori:slug}/{kuis}', [QuisController::class, 'showKuis'])->name('siswa.showKuis');

    });
});