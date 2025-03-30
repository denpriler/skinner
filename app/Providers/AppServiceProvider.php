<?php

namespace App\Providers;

use App\Enums\AppSlug;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AppSlug::class, fn () => Context::get(AppSlug::class, AppSlug::CS_2));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
