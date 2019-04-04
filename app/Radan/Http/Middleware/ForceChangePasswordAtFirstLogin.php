<?php

namespace App\Radan\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ForceChangePasswordAtFirstLogin
{
    /**
     * User last login database field name
     * 
     * @var string
     */
    protected $lastLoginAttribute = 'last_login';

    /**
     * Password change route name
     * 
     * @var string
     */
    protected $passwordChangeRoute = 'password.change.show';

    /**
     * Radan auth module config key for last login action status
     * 
     * @var string
     */
    protected $activityLogConfig = 'radan.auth.userActivityLog';

    /**
     * List of allow routes when force user to change password
     * 
     * @var array
     */
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

    /**
     * Check http request and validate for redirect
     * 
     * @param Illuminate\Http\Request;
     * @return boolean
     */
    protected function checkAllowRoutes($request)
    {
        return !in_array($request->route()->getName(),$this->allowRoutes) &&
                $request->route()->getName() != $this->passwordChangeRoute;
    }

    /**
     * Check user last login 
     * 
     * @param User;
     * @return boolean
     */
    protected function checkUserLastLogin($user)
    {
       //dd(Carbon::parse($user->getAttribute($this->lastLoginAttribute))->diffInSeconds());        
        return  config($this->activityLogConfig,false) &&
                (
                    is_null($user->getAttribute($this->lastLoginAttribute))                   
                );
    }
}