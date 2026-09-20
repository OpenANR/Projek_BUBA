<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/materi', [MateriController::class, 'index'])->name('index.materi');
// Route::get('/materi/add', [MateriController::class, 'add'])->name('materi.add');
// Route::post('/materi/store', [MateriController::class, 'store'])->name('materi.store');
// Route::get('/materi/show/{id}', [MateriController::class, 'show'])->name('materi.detail_materi');
// Route::get('/materi/edit/{id}', [MateriController::class, 'edit'])->name('materi.edit');
// Route::put('/materi/edit/{id}', [MateriController::class, 'update'])->name('materi.update');
// Route::delete('/materi/delete/{id}', [MateriController::class, 'destroy'])->name('materi.delete');

Route::prefix('admin')->group(function (){
    Route::get('/kelas/index', function () {
        return view('admin.kelas.index');
    });
});