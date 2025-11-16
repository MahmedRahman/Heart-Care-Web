<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS when behind a proxy that indicates HTTPS
        if (request()->header('X-Forwarded-Proto') === 'https' || 
            request()->header('X-Forwarded-Ssl') === 'on' ||
            (config('app.env') === 'production' && !app()->runningInConsole())) {
            URL::forceScheme('https');
        }
    }
}
