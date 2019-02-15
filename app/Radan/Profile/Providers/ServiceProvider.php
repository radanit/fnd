<?php

namespace App\Radan\Profile\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Read current password policy for user authnticated
         */
        if (Auth::guard('api')->check()) {

            // Laravel validation extend for check does not contain string
            Validator::extend('not_contains', function($attribute, $value, $parameters) {
                return (stripos($value, $parameters[0]) !== false) ? false : true;
            });

            // Laravel validation extend for check passwordPolicy
            Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
                $user  =  Auth::guard('api')->user();
                if ($passwordPolicy = $user->profileUser->profile->passwordPolicy) {                    
                    // Make validatore instance
                    $validator = $passwordPolicy->makeValidationRule($attribute, $value, $parameters);
                    
                    // Check validation rule and return result
                    return $validator->validate();
                } else {
                    return true;
                }
            });
        }
    }
}
