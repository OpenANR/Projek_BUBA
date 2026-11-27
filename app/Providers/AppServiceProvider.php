<?php

namespace App\Providers;

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Quis;
use App\Models\Reward;
use App\Models\User;
use App\Observers\DataChangeObserver;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api-login', function (Request $request) {
            $email = Str::lower((string) $request->input('email'));

            return Limit::perMinute(5)
                ->by($email.'|'.$request->ip())
                ->response(function (Request $request, array $headers) {
                    $detik = $headers['Retry-After'] ?? 60;

                    return response()->json([
                        'success' => false,
                        'message' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam '.$detik.' detik.',
                    ], 429, $headers);
                });
        });

        Kelas::observe(DataChangeObserver::class);
        Kategori::observe(DataChangeObserver::class);
        Materi::observe(DataChangeObserver::class);
        Quis::observe(DataChangeObserver::class);
        Reward::observe(DataChangeObserver::class);
        User::observe(DataChangeObserver::class);

        // Kustomisasi Tampilan Email Verifikasi sesuai Tema Aplikasi BUBA
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Konfirmasi Alamat Email - BUBA')
                ->view('emails.verify-email', [
                    'user' => $notifiable,
                    'url' => $url,
                ])
                ->text('emails.verify-email-text', [
                    'user' => $notifiable,
                    'url' => $url,
                ]);
        });

        // Kustomisasi Tampilan Email Lupa / Atur Ulang Kata Sandi sesuai Tema Aplikasi BUBA
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = ResetPassword::$createUrlCallback
                ? call_user_func(ResetPassword::$createUrlCallback, $notifiable, $token)
                : url(route('password.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false));

            $expireMinutes = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire', 60);

            return (new MailMessage)
                ->subject('Atur Ulang Kata Sandi - BUBA')
                ->view('emails.reset-password', [
                    'user' => $notifiable,
                    'url' => $url,
                    'expireMinutes' => $expireMinutes,
                ])
                ->text('emails.reset-password-text', [
                    'user' => $notifiable,
                    'url' => $url,
                    'expireMinutes' => $expireMinutes,
                ]);
        });
    }
}
