<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $url = env('APP_URL');
        $port = $request->server('SERVER_PORT', 80);
        $fallbackOrigin = sprintf('%s:%s', $url, $port);
        $origin = env('ALLOWED_CORS_ORIGIN', $fallbackOrigin);
        $response->header('Access-Control-Allow-Origin', $origin);

        return $response;
    }
}
