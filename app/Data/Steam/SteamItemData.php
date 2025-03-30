<?php

namespace App\Data\Steam;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class SteamItemData extends Data
{
    private const string ITEM_MARKET_BASE_URL = 'https://steamcommunity.com/market/listings';

    public readonly string $itemPageUrl;

    public function __construct(
        public readonly string $name,
        public readonly string $hashName,
        public readonly int $sellListings,
        public readonly int $sellPrice,
        public readonly SteamItemAssetDescriptionData $assetDescription,
    ) {
        $this->itemPageUrl = $this->getItemPageUrl();
    }

    private function getItemPageUrl(): string
    {
        return sprintf(
            '%s/%s/%s',
            self::ITEM_MARKET_BASE_URL,
            $this->assetDescription->appId,
            rawurlencode($this->hashName),
        );
    }
}
