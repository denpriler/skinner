<?php

namespace App\Attributes;

use App\Enums\Provider;
use Attribute;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;
use Illuminate\Support\Arr;

#[Attribute(Attribute::TARGET_PARAMETER)]
class AppArray implements ContextualAttribute
{
    /**
     * Create a new attribute instance.
     */
    public function __construct(public Provider $key, public Provider $default = Provider::STEAM) {}

    /**
     * Resolve the configuration value.
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    public static function resolve(self $attribute, Container $container): array
    {
        return Arr::get($container->make('config')->get('app.apps'), $attribute->key->value);
    }
}
