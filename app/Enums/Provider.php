<?php

namespace App\Enums;

use App\Enums\Traits\HasStringArray;

enum Provider: string
{
    use HasStringArray;

    case STEAM = 'steam';

    public static function getDefaultProvider(): self
    {
        return self::STEAM;
    }
}
