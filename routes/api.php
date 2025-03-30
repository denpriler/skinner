<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\ItemController;

Route::apiResource('app', AppController::class)
    ->only(['index', 'show']);

Route::prefix('{provider}/{app_slug}')
    ->middleware(['provider', 'app_slug', 'app_enabled'])
    ->group(function () {
        Route::prefix('item')
            ->name('item.')
            ->group(function () {
                Route::get('/search', [ItemController::class, 'search'])->name('search');
            });
    });
