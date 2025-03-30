<?php

namespace App\Data;

use App\Data\Steam\SteamItemData;
use App\Enums\AppSlug;
use Carbon\FactoryImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ItemData extends Data
{
    public function __construct(
        public readonly AppSlug $appSlug,
        public readonly string $name,
        public readonly float $lastUpdatedPrice,
        public readonly int $lastUpdatedAmount,
        public readonly string $iconUrl,
        public readonly string $pageUrl,
        public readonly ?FactoryImmutable $lastUpdate = null,
    ) {}

    public static function fromSteamItem(AppSlug $appSlug, SteamItemData $item): self
    {
        return new self(
            $appSlug,
            $item->name,
            round($item->sellPrice / 100, 2),
            $item->sellListings,
            $item->assetDescription->fullIconUrl,
            $item->itemPageUrl
        );
    }

    public static function fromSteamItems(AppSlug $appSlug, array|Collection $items): array
    {
        return collect($items)
            ->map(fn (SteamItemData $item) => self::fromSteamItem($appSlug, $item))
            ->toArray();
    }
}
