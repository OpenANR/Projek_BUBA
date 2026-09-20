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
    Route::get('/kelas', function () {
        return view('admin.kelas.index');
    })->name('kelas.index');

    Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');

    Route::get('/materi', function() {
        return view('admin.materi.index');
    })->name('materi.index');

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