<?php

namespace Idempotency;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Idempotency
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->method() != 'POST') {
            return $next($request);
        }

        $requestId = $request->header(config('idempotency.idempotency_header'));
        if (!$requestId) {
            return $next($request);
        }

        if (Cache::has($requestId)) {
            return Cache::get($requestId);
        }

        $response = $next($request);
        $response->header(config('idempotency.idempotency_header'), $requestId);
        Cache::put($requestId, $response, config('idempotency.expiration_in_minutes'));
        return $response;
    }
}
