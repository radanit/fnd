<?php

namespace App\Radan\Profile\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Radan\Profile\Controllers\Api\UserAvatarController;

class ProfileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // merge package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/profile.php', 'profile');

        $this->app->when(UserAvatarController::class)
            ->needs(Filesystem::class)
            ->give(function () {
                return \Storage::disk('profile_avatar');
            });       
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
