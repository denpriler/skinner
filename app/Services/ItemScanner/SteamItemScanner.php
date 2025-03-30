<?php

namespace App\Services\ItemScanner;

use App\Attributes\AppArray;
use App\Data\ItemData;
use App\Data\PaginationData;
use App\Data\Steam\SteamItemData;
use App\Enums\AppSlug;
use App\Enums\Provider;
use App\Exceptions\Item\ItemScanException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

final readonly class SteamItemScanner implements IItemScanner
{
    public function __construct(
        #[AppArray(Provider::STEAM)] private array $apps
    ) {}

    private const string STEAM_MARKER_SEARCH_URL = 'https://steamcommunity.com/market/search/render';

    /**
     * @return ItemData[]
     *
     * @throws ItemScanException
     */
    public function scanByName(AppSlug $appSlug, string $name, PaginationData $pagination): array
    {
        $appId = Arr::get($this->apps, $appSlug->value);

        try {
            $response = Http::asJson()
                ->acceptJson()
                ->get(
                    URL::query(
                        self::STEAM_MARKER_SEARCH_URL,
                        [
                            'appid' => $appId,
                            'l' => 'english',
                            'currency' => 1, // USD,
                            'norender' => 1,
                            'query' => $name,
                            'start' => $pagination->perPage * ($pagination->page - 1),
                            'count' => $pagination->perPage,
                        ]
                    )
                );

            $data = $response->json('results');

            return ItemData::fromSteamItems($appSlug, SteamItemData::collect($data));
        } catch (\Throwable $exception) {
            Log::error($exception);
            throw new ItemScanException(Provider::STEAM, $appSlug, $name, $exception->getMessage());
        }
    }
}
