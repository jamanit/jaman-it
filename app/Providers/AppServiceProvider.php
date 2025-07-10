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
        if (!app()->environment('local')) {
            URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $services = \App\Models\Service::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get();
            $view->with('services', $services);
        });
    }
}
