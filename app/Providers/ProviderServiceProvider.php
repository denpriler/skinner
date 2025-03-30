<?php

namespace App\Providers;

use App\Enums\Provider;
use App\Services\AppScanner\AppScannerBuilder;
use App\Services\AppScanner\IAppScanner;
use App\Services\AppService;
use App\Services\ItemScanner\IItemScanner;
use App\Services\ItemScanner\ItemScannerBuilder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Context;
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
        $this->app->bind(Provider::class, fn () => Context::get(Provider::class, Provider::STEAM));
        // App
        $this->app->singleton(AppScannerBuilder::class);
        $this->app->singleton(IAppScanner::class, function (Application $application) {
            return $application->get(AppScannerBuilder::class)->build();
        });
        // Item
        $this->app->singleton(ItemScannerBuilder::class);
        $this->app->singleton(IItemScanner::class, function (Application $application) {
            return $application->get(ItemScannerBuilder::class)->build();
        });
        //
        $this->app->singleton(AppService::class);
    }
}
