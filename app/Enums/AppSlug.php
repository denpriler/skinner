<?php

namespace App\Enums;

use App\Enums\Traits\HasStringArray;

enum AppSlug: string
{
    use HasStringArray;

    case CS2 = 'cs2';
    case DOTA_2 = 'dota_2';
}
