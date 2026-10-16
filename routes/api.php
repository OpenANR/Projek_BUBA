<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('admin')->name('api.')->group(function () {
    Route::apiResource('kelas', KelasController::class);
});

Route::prefix('siswa')->name('api.')->group(function () {
    Route::prefix('{konten}')->group(function () {
        Route::get('/pilih-kelas', [KelasController::class, 'pilihKelas'])->name('siswa.kelas');
        Route::get('/{kelas}', [CategoryController::class, 'pilihKategori'])->name('siswa.kategori');

        Route::get('/kelas/{kelas}/{kategori}', [MateriController::class, 'listMateri'])->name('siswa.materi');
        Route::get('/kelas/{kelas}/{kategori}/{materi}', [MateriController::class, 'showMateri'])->name('siswa.showMateri');
    });
});