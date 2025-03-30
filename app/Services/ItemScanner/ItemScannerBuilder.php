<?php

namespace App\Services\ItemScanner;

use App\Enums\Provider;
use Illuminate\Contracts\Container\BindingResolutionException;

final readonly class ItemScannerBuilder
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
    public function build(): IItemScanner
    {
        return app()->make(
            match ($this->provider) {
                Provider::STEAM => SteamItemScanner::class
            }
        );
    }
}
