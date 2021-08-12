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

        $reqAccessControl = $request->header('Access-Control-Request-Headers');
        $response->withHeaders([
            'Access-Control-Allow-Methods' => 'HEAD, GET, POST, PUT, PATCH, DELETE',
            'Access-Control-Allow-Headers' => $reqAccessControl,
            'Access-Control-Allow-Origin' => '*'
        ]);

        return $response;
    }
}
