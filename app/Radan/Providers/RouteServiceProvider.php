<?php

namespace App\Radan\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider as BaseRouteServiceProvider;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    protected $namespace='App\Radan\Http\Controllers';

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
            ->prefix('api')
            ->namespace($this->namespace.'\API')
            ->group(__DIR__ . '/../routes/api.php');
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->prefix('')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/web.php');
    }
}
