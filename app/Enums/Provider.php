<?php

namespace App\Enums;

use App\Enums\Traits\HasStringArray;

enum Provider: string
{
    use HasStringArray;

    case STEAM = 'steam';
}
