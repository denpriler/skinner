<?php

namespace App\Http\Controllers;

use App\Data\PaginationData;
use App\Enums\AppSlug;
use App\Http\Resources\ItemResource;
use App\Services\ItemService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ItemController extends Controller
{
    public function __construct(
        private readonly ItemService $itemService,
        private readonly AppSlug $appSlug
    ) {}

    public function search(Request $request): AnonymousResourceCollection
    {
        return ItemResource::collection(
            $this->itemService->searchByName(
                $this->appSlug,
                $request->query('query'),
                PaginationData::fromRequest($request)
            )
        );
    }
}
