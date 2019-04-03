<?php

namespace App\Radan\Providers;

use Illuminate\Support\ServiceProvider;

class RadanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {           
		$this->registerMiddlewareGroups();
		$this->registerRouteMiddleware();
	}

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {     
        $this->registerProviders();		
		$this->registerMiddleware();		
    }
	
	/**
	 * Register Radan pakage service providers
	 *
	 * @return void
	 */
	protected function registerProviders()
	{
		$providers = config('radan.providers');
        foreach ($providers as $provider)
        {
            $this->app->register($provider);
        }        
	}
	
	/**
	 * Register Radan pakage Middlewares
	 *
	 * @return void
	 */
	protected function registerMiddleware()
	{
		$kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');	
		$middlewares = config('radan.middleware');
		foreach($middlewares as $middleware)
		{
			$kernel->pushMiddleware($middleware);
		}		
	}
	
	/**
	 * Register Radan pakage Middleware groups
	 *
	 * @return void
	 */
	protected function registerMiddlewareGroups()
	{
		$middlewareGroups = config('radan.middlewareGroups');
		foreach($middlewareGroups as $group => $middlewares)
		{
			foreach($middlewares as $middleware)
			{				
				$this->app['router']->pushMiddlewareToGroup($group,$middleware);
			}			
		}					
	}
	
	/**
	 * Register Radan pakage route Middlewares
	 *
	 * @return void
	 */
	protected function registerRouteMiddleware()
	{
		$routeMiddleware = config('radan.routeMiddleware');
		foreach($routeMiddleware as $alias => $middleware)
		{			
			$this->app['router']->aliasMiddleware($alias,$middleware);		
		}					
	}
}
