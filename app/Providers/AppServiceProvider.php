<?php

namespace App\Providers;

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Quis;
use App\Models\Reward;
use App\Models\User;
use App\Observers\DataChangeObserver;
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
    }
}
