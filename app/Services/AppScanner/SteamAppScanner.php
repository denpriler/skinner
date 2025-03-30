<?php

namespace App\Services\AppScanner;

use App\Attributes\AppArray;
use App\Data\AppData;
use App\Enums\AppSlug;
use App\Enums\Provider;
use App\Exceptions\App\AppScanException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final readonly class SteamAppScanner implements IAppScanner
{
    public function __construct(
        #[AppArray(Provider::STEAM)] private array $apps
    ) {}

    private const string STEAM_POWERED_STORE_BASE_URL = 'https://store.steampowered.com/api';

    private function buildSteamPoweredStoreUrl(string $url): string
    {
        return sprintf('%s%s', self::STEAM_POWERED_STORE_BASE_URL, $url);
    }

    /**
     * @throws AppScanException
     */
    public function scan(AppSlug $appSlug): AppData
    {
        $appId = Arr::get($this->apps, $appSlug->value);

        try {
            $response = Http::asJson()
                ->acceptJson()
                ->get(
                    url: $this->buildSteamPoweredStoreUrl('/appdetails'),
                    query: ['appids' => $appId, 'l' => 'english']
                );

            $data = $response->json(
                sprintf('%s.data', $appId)
            );

            return AppData::from([
                ...$data,
                'slug' => $appSlug,
                'description' => Arr::get($data, 'short_description'),
                'steam_app_id' => Arr::get($data, 'steam_appid'),
                'image_url' => sprintf('https://cdn.akamai.steamstatic.com/steam/apps/%s/header.jpg', Arr::get($data, 'steam_appid')),
            ]);
        } catch (\Throwable $exception) {
            Log::error($exception);
            throw new AppScanException(Provider::STEAM, $appSlug, $exception->getMessage());
        }
    }
}
