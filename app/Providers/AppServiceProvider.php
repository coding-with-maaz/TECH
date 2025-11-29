<?php

namespace App\Providers;

use App\View\Composers\SeoComposer;
use Illuminate\Support\Facades\View;
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
        // Share SEO data with all views
        View::composer('layouts.app', SeoComposer::class);
    }
}
