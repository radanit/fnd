<?php

namespace App\Radan\Providers;

use Illuminate\Support\ServiceProvider;

class RadanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {           
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       /*
        * Register Radan pakage service providers
        */
        $providers = config('radan.providers');
        foreach ($providers as $provider)
        {
            $this->app->register($provider);
        }        
    }
}
