<?php

namespace App\Radan\Http\Middleware;

use Closure;

class OwnerMiddleware
{	
	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,  $resourceName, $userKey = 'user_id')
    {        
		// Retrieve route parameters
		$routeParameters = $request->route()->parameters();
		if (is_array($routeParameters)) {
			$resourceId = reset($routeParameters);
		}
						
		// Check authenticated user is owner of resource
		$user_id = null;
		if ($resourceId) {
			try {
				// Retrieve resource owner id
				$user_id = \DB::table($resourceName)->find($resourceId)->$userKey;
				if ($request->user()->id != $user_id) {
					throw(new \Exception('Authenticated user does not resource owner'));
				}        
			} catch (\Exception $e) {
				abort(403, 'Unauthorized action.');
			}
		}

		// Check authenticated user is owner of resource
        if ($request->user()->id != $user_id) {
            abort(403, 'Unauthorized action.');
        }        
		
		return $next($request);
    }
}
