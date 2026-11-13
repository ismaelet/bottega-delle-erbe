<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;
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
        // Register Vite image helper
        Vite::macro('image', fn (string $asset) => Vite::asset("resources/images/{$asset}"));

        // Prevent lazy loading in non-production environments
        Model::preventLazyLoading(! app()->isProduction());
    }
}
