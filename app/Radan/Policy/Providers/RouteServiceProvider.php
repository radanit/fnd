<?php

namespace App\Radan\Policy\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    protected $namespace='App\Radan\Policy\Controllers';

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
            ->prefix('api/policies')
            ->namespace($this->namespace.'\Api')
            ->group(__DIR__ . '/../Routes/api.php');
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->prefix('')
            ->namespace($this->namespace.'\Web')
            ->group(__DIR__ . '/../Routes/web.php');
    }
}
