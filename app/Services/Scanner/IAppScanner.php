<?php

namespace App\Services\Scanner;

use App\Data\AppData;
use App\Enums\AppSlug;
use App\Exceptions\App\AppScanException;

interface IAppScanner
{
    /** @throws AppScanException */
    public function getApp(AppSlug $slug): AppData;
}
