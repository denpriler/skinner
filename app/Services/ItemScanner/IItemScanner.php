<?php

namespace App\Services\ItemScanner;

use App\Data\ItemData;
use App\Data\PaginationData;
use App\Enums\AppSlug;

interface IItemScanner
{
    /**
     * @return ItemData[]
     */
    public function scanByName(AppSlug $appSlug, string $name, PaginationData $pagination): array;
}
