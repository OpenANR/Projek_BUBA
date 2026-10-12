<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\KelasController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('admin')->name('api.')->group(function () {
    Route::apiResource('kelas', KelasController::class);
});