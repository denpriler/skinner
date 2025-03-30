<?php

namespace App\Services\AppScanner;

use App\Data\AppData;
use App\Enums\AppSlug;
use App\Exceptions\App\AppScanException;

interface IAppScanner
{
    /** @throws AppScanException */
    public function scan(AppSlug $appSlug): AppData;
}
