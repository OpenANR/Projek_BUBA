<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\QuisController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('admin')->name('api.')->group(function () {
    Route::apiResource('kelas', KelasController::class);
});

Route::prefix('siswa')->name('api.')->group(function () {
    // Membatasi {konten} hanya 'materi' atau 'kuis'
    Route::prefix('{konten}')->whereIn('konten', ['materi', 'kuis'])->group(function () {
        
        // 1. Pilih Kelas -> /api/siswa/materi/pilih-kelas atau /api/siswa/kuis/pilih-kelas
        Route::get('/pilih-kelas', [KelasController::class, 'pilihKelas'])->name('siswa.kelas');
        
        // 2. Pilih Kategori -> /api/siswa/materi/7C atau /api/siswa/kuis/7C
        Route::get('/{kelas}', [CategoryController::class, 'pilihKategori'])->name('siswa.kategori');

        // 3. Rute khusus Materi (diberi awalan path agar tidak bertabrakan dengan rute kuis)
        Route::get('/materi-list/{kelas}/{kategori}', [MateriController::class, 'listMateri'])->name('siswa.materi');
        Route::get('/materi-show/{kelas}/{kategori}/{materi}', [MateriController::class, 'showMateri'])->name('siswa.showMateri');

        // 4. Rute khusus Kuis
        Route::get('/kuis-list/{kelas}/{kategori}', [QuisController::class, 'listKuis'])->name('siswa.kuis');
        Route::get('/kuis-show/{kelas}/{kategori}/{kuis}', [QuisController::class, 'showKuis'])->name('siswa.showKuis');
    });
});