<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
        | For Laravel IDE helper
        */
        if ($this->app->environment('local', 'debug', 'dev')) {
            $this->app->register(
                \Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class
            );
        }
    }
}
