<?php

namespace App\Services;

use App\Data\AppData;
use App\Enums\AppSlug;
use App\Exceptions\App\AppScanException;
use App\Models\App as AppModel;
use App\Services\AppScanner\IAppScanner;

final readonly class AppService
{
    public function __construct(
        private IAppScanner $appScanner,
    ) {}

    public function all(): array
    {
        return AppData::collect(AppModel::all()->toArray());
    }

    public function get(AppSlug $slug): AppData
    {
        return AppData::from(
            AppModel::whereSlug($slug)->firstOrFail()
        );
    }

    /**
     * @throws AppScanException
     */
    public function scan(AppSlug $slug): AppData
    {
        $data = $this->appScanner->scan($slug);

        $app = AppModel::updateOrCreate([
            AppModel::FIELD_SLUG => $slug,
        ], $data->toArray());

        return AppData::from($app);
    }
}
