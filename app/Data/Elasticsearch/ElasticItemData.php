<?php

namespace App\Data\Elasticsearch;

use App\Data\ItemData;
use Closure;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Str;

class ElasticItemData extends ItemData
{
    public function getId(): string
    {
        return sprintf(
            '%s_%s',
            $this->appSlug->value,
            Pipeline::send($this->name)->through([
                function (string $name, Closure $next) {
                    return $next(Str::remove(['|', '(', ')'], $name));
                },
                function (string $name, Closure $next) {
                    return $next(Str::replace('-', '_', $name));
                },
                function (string $name, Closure $next) {
                    return $next(Str::snake($name));
                },
            ])->then(fn (string $name) => $name),
        );
    }
}
