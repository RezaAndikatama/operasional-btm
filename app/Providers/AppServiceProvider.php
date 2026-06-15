<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Jika aplikasi diakses selain dari localhost langsung, paksa gunakan HTTPS
        if (env('APP_ENV') !== 'local' || request()->header('x-forwarded-proto') == 'https') {
            URL::forceScheme('https');
        }
    }
}
