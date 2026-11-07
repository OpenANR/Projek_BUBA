<?php

namespace App\Providers;

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Quis;
use App\Models\Reward;
use App\Models\User;
use App\Observers\DataChangeObserver;
use Illuminate\Support\ServiceProvider;

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
        Kelas::observe(DataChangeObserver::class);
        Kategori::observe(DataChangeObserver::class);
        Materi::observe(DataChangeObserver::class);
        Quis::observe(DataChangeObserver::class);
        Reward::observe(DataChangeObserver::class);
        User::observe(DataChangeObserver::class);
    }
}
