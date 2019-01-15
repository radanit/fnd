<?php

namespace App\Radan\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RadanAuthRouteServiceProvider extends RouteServiceProvider
{
    protected $namespace='App\Radan\Auth\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }


    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->prefix('auth/api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/api.php');
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->prefix('')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/web.php');
    }
}
