<?php

namespace App\Attributes;

use App\Enums\Provider;
use App\Services\Scanner\AppScannerBuilder;
use App\Services\Scanner\IAppScanner;
use Attribute;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class AppScannerProvider implements ContextualAttribute
{
    /**
     * Create a new attribute instance.
     */
    public function __construct(public Provider $key, public mixed $default = null) {}

    /**
     * Resolve the configuration value.
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    public static function resolve(self $attribute, Container $container): IAppScanner
    {
        return $container->make(AppScannerBuilder::class, [$attribute->key])->build();
    }
}
