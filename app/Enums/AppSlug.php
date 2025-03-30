<?php

namespace App\Enums;

use App\Enums\Traits\HasStringArray;

enum AppSlug: string
{
    use HasStringArray;

    case CS_2 = 'cs_2';
    case DOTA_2 = 'dota_2';
}
