<?php

namespace App\Radan\Auth\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Radan\Auth\Controllers\LoginController;
use App\Radan\Contracts\Repository;

/**
 * Service Provider for Config
 *
 * @package App\Radan\Config;
 */
class ServiceProvider extends BaseServiceProvider
{
    protected $defer = false;

    /**
     * @inheritdoc
     */
    public function boot()
    {
        # publish necessary files        
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->bind('App\Radan\Contracts\Repository','config-runtime');
    }
}
