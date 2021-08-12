<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CatchAllOptionsRequestsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $request = app('request');
        if ($request->isMethod('options')) {
            app()->router->options($request->path(), function () {
                return response('', 200);
            });
        }
    }
}
