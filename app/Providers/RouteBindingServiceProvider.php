<?php

namespace App\Providers;

use mmghv\LumenRouteBinding\RouteBindingServiceProvider as BaseServiceProvider;

class RouteBindingServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $binder = $this->binder;
        $binder->bind('user', 'App\Models\User');
        $binder->bind('doctor', 'App\Models\Doctor');
        $binder->bind('drug', 'App\Models\Drug');
        $binder->bind('customer', 'App\Models\Customer');
        $binder->bind('sale', 'App\Models\Sale');
        $binder->bind('User', 'App\Models\User');
    }
}
