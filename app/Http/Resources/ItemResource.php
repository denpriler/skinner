<?php

namespace App\Http\Resources;

use App\Data\ItemData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /** @var ItemData */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'app' => $this->resource->appSlug,
            'name' => $this->resource->name,
            'price' => $this->resource->lastUpdatedPrice,
            'amount' => $this->resource->lastUpdatedAmount,
            'icon_url' => $this->resource->iconUrl,
            'page_url' => $this->resource->pageUrl,
        ];
    }
}
