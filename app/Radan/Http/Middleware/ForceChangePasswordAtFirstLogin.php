<?php

namespace App\Radan\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceChangePasswordAtFirstLogin
{
    
    protected $lastLoginAttribute = 'last_login';

    protected $passwordChangeRoute = 'password.change.show';

    protected $activityLogConfig = 'radan.auth.userActivityLog';
    
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
        if ($user = Auth::guard($guard)->user()) {            
                        
            // Check if user not login and user activity log in true
            if (is_null($user->getAttribute($this->lastLoginAttribute)) && 
                $request->route()->getName() != $this->passwordChangeRoute &&
                config($this->activityLogConfig,false)) {
                    return redirect()->route($this->passwordChangeRoute);
            }
        }

        return $next($request);
    }
}