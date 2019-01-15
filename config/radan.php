<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [
        /*
         * Radan Fundation Service Providers...
         */
        // Radan Auth pakage service providers
        App\Radan\Auth\Providers\ServiceProvider::class,
        App\Radan\Auth\Providers\RouteServiceProvider::class,
        
        // Radan Config pakage service providers
        App\Radan\Config\Providers\ServiceProvider::class,
        App\Radan\Config\Providers\RouteServiceProvider::class,
    ],
];
