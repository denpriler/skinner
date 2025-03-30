<?php

namespace App\Data;

use App\Enums\AppSlug;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapInputName(SnakeCaseMapper::class)]
final class AppData extends Data
{
    public int $id;

    public AppSlug $slug;

    public string $name;

    public string|Optional $description;

    #[MapOutputName('image_url')]
    public string|Optional $imageUrl;

    #[MapOutputName('steam_app_id')]
    public int|Optional $steamAppId;

    #[MapOutputName('updated_at')]
    public CarbonImmutable $updatedAt;

    #[MapOutputName('created_at')]
    public CarbonImmutable $createdAt;
}
