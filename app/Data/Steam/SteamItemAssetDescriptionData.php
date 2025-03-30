<?php

namespace App\Data\Steam;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
final class SteamItemAssetDescriptionData extends Data
{
    private const string BASE_ICON_URL = 'https://steamcommunity-a.akamaihd.net/economy/image';

    public readonly string $fullIconUrl;

    public function __construct(
        #[MapInputName('appid')]
        public readonly int $appId,
        #[MapInputName('classid')]
        public readonly string $classId,
        #[MapInputName('instanceid')]
        public readonly string $instanceId,
        public readonly string $iconUrl,
        public readonly string $type,
        public readonly int $tradable,
        public readonly int $commodity,
    ) {
        $this->fullIconUrl = $this->getFullIconUrl();
    }

    private function getFullIconUrl(): string
    {
        return sprintf(
            '%s/%s',
            self::BASE_ICON_URL,
            $this->iconUrl,
        );
    }
}
