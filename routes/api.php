<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\QuisController;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Auth)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

/*
|--------------------------------------------------------------------------
| Protected Routes (Khusus Siswa yang Login via Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth & Profil
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');

    Route::prefix('siswa')->name('api.siswa.')->group(function () {
        
        // 1. Kelas & Kategori
        Route::get('/kelas', [KelasController::class, 'pilihKelas']);
        Route::get('/kategori/{kelas_id}', [CategoryController::class, 'pilihKategori']);

        // 2. Materi
        Route::get('/materi', [MateriController::class, 'listMateri']); // parameter via query ?kelas_id=1&kategori_id=2
        Route::get('/materi/{kode_materi}', [MateriController::class, 'showMateri']);

        // 3. Kuis
        Route::get('/kuis', [QuisController::class, 'listKuis']); // ambil soal kuis tanpa kunci jawaban
        Route::post('/kuis/submit', [QuisController::class, 'submitKuis']); // kirim jawaban & hitung nilai

        // 4. Hasil Pengerjaan / Reward
        Route::get('/hasil-kuis', [QuisController::class, 'riwayatHasil']); // lihat bintang & skor
    });
});