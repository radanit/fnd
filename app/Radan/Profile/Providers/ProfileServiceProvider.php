<?php

namespace App\Radan\Profile\Providers;

use Illuminate\Support\ServiceProvider;

class ProfileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->mergeConfigFrom(
            __DIR__.'/../config/profile.php', 'profile');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register user avatar storage disk
        $this->app['config']["filesystems.disks.profile_avatar"] = $this->app['config']['profile.profile_avatar.disk'];
    }
}
