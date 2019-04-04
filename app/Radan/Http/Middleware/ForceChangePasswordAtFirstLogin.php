<?php

namespace App\Radan\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceChangePasswordAtFirstLogin
{
    
    protected $lastLoginAttribute = 'last_login';

    protected $passwordChangeRoute = 'password.change.show';

    protected $activityLogConfig = 'radan.auth.userActivityLog';

    protected $allowRoutes = [
        'logout',
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {        
        if (Auth::guard($guard)->check() && $this->checkAllowRoutes($request))                
        {                    
            if ($this->checkUserLastLogin(Auth::guard($guard)->user())) 
            {
                return redirect()->route($this->passwordChangeRoute);
            }
        }

        return $next($request);
    }

    protected function checkAllowRoutes($request)
    {
        return !in_array($request->route()->getName(),$this->allowRoutes) &&
                $request->route()->getName() != $this->passwordChangeRoute;
    }

    protected function checkUserLastLogin($user)
    {
        return  config($this->activityLogConfig,false) &&
                is_null($user->getAttribute($this->lastLoginAttribute)); 
    }
}