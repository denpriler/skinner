<?php

namespace App\Http\Middleware;

use App\Enums\AppSlug as AppSlugEnum;
use App\Models\App;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class AppEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var AppSlugEnum $appSlug */
        $appSlug = app(AppSlugEnum::class);

        $enabled = Cache::remember(sprintf('enabled:%s', $appSlug->value), 60 * 60, function () use ($appSlug) {
            return App::whereSlug($appSlug)->first(['id', 'slug', 'enabled'])?->enabled ?? false;
        });

        if (! $enabled) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return $next($request);
    }
}
