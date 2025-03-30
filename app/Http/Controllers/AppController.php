<?php

namespace App\Http\Controllers;

use App\Enums\AppSlug;
use App\Http\Resources\AppResource;
use App\Services\AppService;
use Illuminate\Http\Request;

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
        //

        return response()->json([]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        return response()->json([]);
    }

    /**
     * Show the specified App.
     */
    public function show(AppSlug $appSlug): AppResource
    {
        return AppResource::make($this->appService->get($appSlug));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        return response()->json([]);
    }
}
