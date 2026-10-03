<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\QuisController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('menu');
})->name('home');

// Route::get('/materi', [MateriController::class, 'index'])->name('index.materi');
// Route::get('/materi/add', [MateriController::class, 'add'])->name('materi.add');
// Route::post('/materi/store', [MateriController::class, 'store'])->name('materi.store');
// Route::get('/materi/show/{id}', [MateriController::class, 'show'])->name('materi.detail_materi');
// Route::get('/materi/edit/{id}', [MateriController::class, 'edit'])->name('materi.edit');
// Route::put('/materi/edit/{id}', [MateriController::class, 'update'])->name('materi.update');
// Route::delete('/materi/delete/{id}', [MateriController::class, 'destroy'])->name('materi.delete');

Route::prefix('admin')->group(function (){

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // RUTE HALAMAN KELAS
    Route::resource('kelas', KelasController::class)->except(['show']);
    // =================================================

    // RUTE HALAMAN KATEGORI
    Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/tambah', [CategoryController::class, 'add'])->name('kategori.tambah');
    Route::post('/kategori/kirim', [CategoryController::class, 'store'])->name('kategori.kirim');
<<<<<<< HEAD
=======
    Route::get('/kategori/edit/{kategori}', [CategoryController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/edit/{kategori}', [CategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/hapus/{kategori}', [CategoryController::class, 'destroy'])->name('kategori.hapus');
>>>>>>> 62312ce (Perbaikan kategori)
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
    Route::get('/siswa', function() {
        return view('admin.siswa.index');
    })->name('siswa.index');
    // =================================================

    // RUTE REWARD
    Route::get('/reward', function(){
        return view('admin.reward.index');
    })->name('reward.index');
});

Route::prefix('siswa')->group(function () {
    Route::get('/welcome', function() {
        return view('siswa.splash');
    });
});
