<?php

namespace App\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class PaginationData extends Data
{
    public function __construct(
        public readonly int $page,
        public readonly int $perPage,
    ) {}

    public static function default(): self
    {
        return new self(1, 10);
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('page', 1),
            $request->get('per_page', 10)
        );
    }
}
