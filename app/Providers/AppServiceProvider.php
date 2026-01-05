<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\CartComposer;
use App\View\Composers\AdminNotificationComposer;

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
        // Share cart count to all views
        View::composer('layouts.frontend', CartComposer::class);
        
        // Share new orders count to admin layout
        View::composer('layouts.admin', AdminNotificationComposer::class);
    }
}
