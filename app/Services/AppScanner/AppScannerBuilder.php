<?php

namespace App\Services\AppScanner;

use App\Enums\Provider;
use Illuminate\Contracts\Container\BindingResolutionException;

final readonly class AppScannerBuilder
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private Provider $provider,
    ) {
        //
    }

    /**
     * @throws BindingResolutionException
     */
    public function build(): IAppScanner
    {
        return app()->make(
            match ($this->provider) {
                Provider::STEAM => SteamAppScanner::class
            }
        );
    }
}
