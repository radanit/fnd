<?php

namespace App\Radan\Profile\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Radan\Profile\Profile;
use App\Radan\Profile\ProfileFacade;


class ProfileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/profile.php', 'profile');

        // Extend filesystems disk configuration to add profile package disk
        $this->app['config']["filesystems.disks.profile_disk"] = $this->app['config']['profile.disks.profile_disk'];

        // Contextual Binding
        $this->app->when(Controller::class)->needs(Filesystem::class)->give(function () {
            return \Storage::disk('profile_disk');
        });

        // Create singleton profile instance
        $this->app->singleton('profile.manager', function ($app) {        
            $profile = new Profile(\Storage::disk('profile_disk'));
            return $profile;
        });
        
        // Register Facade
        $loader = AliasLoader::getInstance();
        $loader->alias('Profile', ProfileFacade::class);
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
