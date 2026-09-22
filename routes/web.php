<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\CategoryController;

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

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/kelas', function () {
        return view('admin.kelas.index');
    })->name('kelas.index');

    Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/tambah', [CategoryController::class, 'add'])->name('kategori.tambah');
    Route::post('/kategori/kirim', [CategoryController::class, 'store'])->name('kategori.kirim');

    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/tambah', [MateriController::class, 'add'])->name('materi.tambah');
    Route::post('/materi/kirim', [MateriController::class, 'store'])->name('materi.kirim');
    Route::get('/materi/detail/{materi}', [MateriController::class, 'show'])->name('materi.detail');
    Route::get('/materi/edit/{materi}', [MateriController::class, 'edit'])->name('materi.edit');
    Route::put('/materi/update/{materi}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/hapus/{materi}', [MateriController::class, 'destroy'])->name('materi.hapus');

    Route::get('/kuis', function () {
        return view('kuis.index');
    })->name('kuis.index');

    Route::get('/siswa', function() {
        return view('admin.siswa.index');
    })->name('siswa.index');

    Route::get('/kuis', function () {
        return view('admin.kuis.index');
    })->name('kuis.index');
});