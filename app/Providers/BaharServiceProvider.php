<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BaharServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Extend filesystems disk configuration to add reception attachments disk
        $this->app['config']["filesystems.disks.reception_disk"] = $this->app['config']['bahar.reception.disk'];        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
