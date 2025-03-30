<?php

namespace App\Providers;

use App\Enums\Provider;
use App\Services\AppService;
use App\Services\Scanner\AppScannerBuilder;
use App\Services\Scanner\IAppScanner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ProviderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerSteamProvider();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function registerSteamProvider(): void
    {
        $this->app->singleton(AppScannerBuilder::class, function () {
            /** @var Provider $provider */
            $provider = Route::getCurrentRoute()?->parameter('provider') ?? Provider::STEAM;

            return new AppScannerBuilder($provider);
        });
        $this->app->singleton(IAppScanner::class, function (Application $application) {
            return $application->get(AppScannerBuilder::class)->build();
        });
        $this->app->singleton(AppService::class);
    }
}
