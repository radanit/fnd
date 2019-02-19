<?php

namespace App\Radan\PasswordPolicy\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {        
        // Get Password Policy feature status form config
        $usePasswordPolicyFeature = Config::get('radan.password_policy.use_password_policy',false);
        $passwordPolicyName = Config::get('radan.password_policy.password_policy_validation_name','password');
        if ($usePasswordPolicyFeature) {
            $this->extendValidatorFromUserProfile($passwordPolicyName);
        } else {
            $this->extendValidatorDefault($passwordPolicyName);
        }        
    }
    
    /**
     * Set password policy based on user profile password policy
     *
     * @return void
     */
    protected function extendValidatorFromUserProfile($passwordPolicyName)
    {        
        // Read current password policy for user authnticated                
        if (Auth::guard('api')->check()) {
            // Laravel validation extend for check does not contain string
            Validator::extend('not_contains', function($attribute, $value, $parameters) {
                return (stripos($value, $parameters[0]) !== false) ? false : true;
            });

            // Laravel validation extend for check passwordPolicy
            Validator::extend($passwordPolicyName, function ($attribute, $value, $parameters, $validator) {
                $user = Auth::guard('api')->user();
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

    /**
     * Set password policy based on config, call when password policy
     * feature is disabled.
     *
     * @return void
     */
    protected function extendValidatorDefault($passwordPolicyName)
    {
        // Laravel validation extend for check passwordPolicy
        Validator::extend($passwordPolicyName, function ($attribute, $value, $parameters, $validator) {            
            // Password Policy feature is disable.
            $validationRule = Config::get('radan.password_policy.password_policy_default','');
            $validator = Validator::make([$attribute => $value],[$attribute => $validationRule]);                            
            // Check validation rule and return result
            return $validator->validate();
        });
    }
}
