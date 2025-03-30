<?php

namespace App\Data;

use App\Enums\AppSlug;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
final class AppData extends Data
{
    public int $id;

    public AppSlug $slug;

    public string $name;

    public string|Optional $description;

    #[MapOutputName('image_url')]
    public string|Optional $imageUrl;

    public bool $enabled;
}
