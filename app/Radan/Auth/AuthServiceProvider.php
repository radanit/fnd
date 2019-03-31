<?php

namespace App\Radan\Auth;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Radan\Auth\Controllers\LoginController;
use App\Radan\Fundation\Contracts\Repository;

/**
 * Service Provider for Config
 *
 * @package App\Radan\Config;
 */
class AuthServiceProvider extends BaseServiceProvider
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
        $this->app->bind('App\Radan\Fundation\Contracts\Repository','config-runtime');
    }
}
