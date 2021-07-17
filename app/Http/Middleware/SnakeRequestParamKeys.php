<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\ParameterBag;

class SnakeRequestParamKeys
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
        if ($request->isJson())
            $this->normalize($request->json());
        else
            $this->normalize($request->request);

        return $next($request);
    }

   /**
    * Normalize request data keys.
    *
    * @param  \Symfony\Component\HttpFoundation\ParameterBag  $bag
    * @return void
    */
    private function normalize(ParameterBag $bag)
    {
        $bag->replace($this->normalizeKeys($bag->all()));
    }

    /**
    * Change parameter names to snake case.
    *
    * @param  array  $data
    * @return array
    */
    private function normalizeKeys(array $data)
    {
        return collect($data)->mapWithKeys(function($v, $k) {
            if (!Str::startsWith($k, '_'))
                $k = Str::snake($k);
            if (is_array($v))
                $v = $this->normalizeKeys($v);
            return [$k => $v];
        })->all();
    }
}
