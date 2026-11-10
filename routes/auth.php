<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::get('verify-email/{id}/{hash}', function (\Illuminate\Http\Request $request, $id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Tautan verifikasi tidak valid.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new \Illuminate\Auth\Events\Verified($user));
    }

    if ($request->user()) {
        $targetRoute = $request->user()->role === 'siswa'
            ? route('siswa.splash', absolute: false)
            : route('admin.dashboard', absolute: false);
        return redirect()->intended($targetRoute . '?verified=1');
    }

    return response('<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Berhasil Diverifikasi | BUBA</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f0f7ff; margin: 0; padding: 20px; box-sizing: border-box; }
        .card { background: white; padding: 40px 30px; border-radius: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); max-width: 420px; text-align: center; border: 1.5px solid #bae6fd; }
        .icon { font-size: 56px; margin-bottom: 16px; }
        h2 { color: #1e60be; margin: 0 0 12px 0; font-size: 24px; }
        p { color: #475569; font-size: 15px; line-height: 1.6; margin: 0 0 24px 0; }
        .badge { display: inline-block; background: #e0f2fe; color: #0284c7; padding: 8px 18px; border-radius: 20px; font-weight: 600; font-size: 13px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">🎉</div>
        <h2>Email Berhasil Diverifikasi!</h2>
        <p>Halo <strong>' . htmlspecialchars($user->name) . '</strong>, akun Anda telah aktif. Silakan buka kembali aplikasi <strong>BUBA</strong> di ponsel Anda untuk mulai belajar.</p>
        <div class="badge">Aplikasi BUBA siap digunakan</div>
    </div>
</body>
</html>');
})
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
