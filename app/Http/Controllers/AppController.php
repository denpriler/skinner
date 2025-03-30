<?php

namespace App\Http\Controllers;

use App\Enums\AppSlug;
use App\Http\Resources\AppResource;
use App\Services\AppService;

final class AppController extends Controller
{
    public function __construct(
        private readonly AppService $appService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AppResource::collection($this->appService->all());
    }

    /**
     * Show the specified App.
     */
    public function show(AppSlug $appSlug): AppResource
    {
        return AppResource::make($this->appService->get($appSlug));
    }
}
