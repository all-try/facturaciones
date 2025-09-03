<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Venta;
use App\Observers\VentaObserver;

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
        Venta::observe(VentaObserver::class);
    }
}
