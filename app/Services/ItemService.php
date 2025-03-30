<?php

namespace App\Services;

use App\Data\Elasticsearch\ElasticItemData;
use App\Data\ItemData;
use App\Data\PaginationData;
use App\Enums\AppSlug;
use App\Jobs\ElasticsearchUpdateItems;
use App\Services\ItemScanner\IItemScanner;

final readonly class ItemService
{
    public function __construct(
        private IItemScanner $itemScanner,
    ) {}

    /**
     * @return ItemData[]
     */
    public function searchByName(AppSlug $appSlug, string $name, ?PaginationData $pagination = null): array
    {
        $items = $this->itemScanner->scanByName($appSlug, $name, $pagination ?? PaginationData::default());

        if (count($items)) {
            ElasticsearchUpdateItems::dispatch(ElasticItemData::collect($items));
        }

        return ItemData::collect($items);
    }
}
