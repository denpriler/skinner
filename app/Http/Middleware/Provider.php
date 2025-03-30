<?php

namespace App\Http\Middleware;

use App\Enums\Provider as ProviderEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

class Provider
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Context::add(ProviderEnum::class, $request->route('provider'));

        return $next($request);
    }
}
