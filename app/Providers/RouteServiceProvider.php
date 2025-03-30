<?php

namespace App\Providers;

use App\Enums\AppSlug;
use App\Enums\Provider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerGlobalResourceParametersMapping();
        $this->registerRouteParameters();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function registerGlobalResourceParametersMapping(): void
    {
        Route::resourceParameters([
            'app' => 'app_slug',
        ]);
    }

    private function registerRouteParameters(): void
    {
        Route::whereIn('app_slug', AppSlug::cases());
        Route::bind('app_slug', fn (string $value) => AppSlug::tryFrom($value) ?? throw new NotFoundHttpException);

        Route::whereIn('provider', Provider::cases());
        Route::bind('provider', fn (string $value) => Provider::tryFrom($value) ?? throw new NotFoundHttpException);
    }
}
