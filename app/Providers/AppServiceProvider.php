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
                ->orderBy('order', 'asc')
                ->get();

            $serviceBadgeColors = [
                ['bg-blue-600 hover:bg-blue-700'],
                ['bg-pink-600 hover:bg-pink-700'],
                ['bg-yellow-500 hover:bg-yellow-700'],
                ['bg-green-600 hover:bg-green-700'],
                ['bg-purple-600 hover:bg-purple-700'],
                ['bg-red-600 hover:bg-red-700'],
                ['bg-sky-600 hover:bg-sky-700'],
                ['bg-rose-600 hover:bg-rose-700'],
                ['bg-amber-600 hover:bg-amber-700'],
                ['bg-lime-600 hover:bg-lime-700'],
                ['bg-indigo-600 hover:bg-indigo-700'],
                ['bg-fuchsia-600 hover:bg-fuchsia-700'],
            ];
            shuffle($serviceBadgeColors);

            $view->with([
                'services' => $services,
                'serviceBadgeColors' => $serviceBadgeColors,
            ]);
        });
    }
}
