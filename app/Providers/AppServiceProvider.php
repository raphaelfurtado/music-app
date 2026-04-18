<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        if (str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\Gate::define('admin', function (\App\Models\User $user) {
            return $user->is_admin === true || $user->is_admin === 1;
        });
    }
}
