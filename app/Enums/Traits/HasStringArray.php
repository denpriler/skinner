<?php

namespace App\Enums\Traits;

trait HasStringArray
{
    public static function toStringArray(): array
    {
        return collect(self::cases())->map(fn (self $item) => $item->value)->toArray();
    }
}
