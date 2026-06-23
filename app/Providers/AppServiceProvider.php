<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Sparepart;
use Illuminate\Support\Facades\Auth;

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
        // Bagikan data stok kritis ke seluruh view jika user sudah login
        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Mengambil sparepart yang stoknya menyentuh atau di bawah min_stock
                $criticalStocks = Sparepart::whereRaw('stock <= min_stock')->get();

                $view->with('criticalStocks', $criticalStocks);
            }
        });
    }
}
