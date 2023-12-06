<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('menuActive', function ($route) {
            return "{{ Route::is($route) ? 'active bg-gradient-primary' : '' }}";
        });

        Blade::directive('menuActiveCollapsed', function ($route) {
            return "{{ Route::is($route) ? 'active collapsed' : '' }}";
        });

        Blade::directive('menuShow', function ($route) {
            return "{{ Route::is($route) ? 'show' : '' }}";
        });

        Blade::directive('menuActiveSub', function ($route) {
            return "{{ Route::is($route) ? 'active' : '' }}";
        });
    }
}
