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
        $ip = $request->ip();
        if (!app()->environment('local') && $ip != '127.0.0.1')
            return $response;

        $origin = $request->header('Origin');
        if ($origin)
            $response->header('Access-Control-Allow-Origin', $origin);

        return $response;
    }
}
