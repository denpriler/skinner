<?php

namespace App\Http\Middleware;

use App\Enums\AppSlug as AppSlugEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

class AppSlug
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Context::add(AppSlugEnum::class, $request->route('app_slug'));

        return $next($request);
    }
}
