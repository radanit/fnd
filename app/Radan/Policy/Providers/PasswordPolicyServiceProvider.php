<?php

namespace App\Radan\Policy\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Config\Repository as Config;
use \PasswordPolicy\PolicyManager as PasswordPolicyManager;
use App\Radan\Policy\Models\PasswordPolicy;

class PasswordPolicyServiceProvider extends BaseServiceProvider
{    
    
    /**
     * Private provider attribute for handeling IOC configuration object.
     * 
     */ 
    protected $config;        

    /**
     * Bootstrap any application services.
     * 
     * @param Illuminate\Config\Repository $config Configuration Serive container
     *
     * @return void
     */
    public function boot(Config $config)
    {
        $this->config = $config;
        $this->defineDefaultPasswordPolicy();
        $this->definePasswordPolicy();       
    }
    
    /**
     * Extend laravel Validation by default Password Policy.
     *
     * @return void
     */
    protected function defineDefaultPasswordPolicy()
    {
        $method = 'get'. $this->getPolicyDriver() . 'DefaultRules';
        $bulder = $this->$method();
        PasswordPolicyManager::define('fefault', $builder);
    }

    /**
     * Extend laravel Validation by user Password Policy.
     *
     * @return void
     */
    protected function defineUserPasswordPolicy()
    {
        $method = 'get'. $this->getPolicyDriver() . 'UserRules';
        $builder = $this->$method();
        PasswordPolicyManager::define('user', $builder);
    }

    /**
     * Get current Password Policy Driver form configuration
     * 
     * @return stirng
     */
    protected function getPolicyDriver()
    {
        return ucfirst($this->config->get('radan.password_policy.driver')).'Driver';
    }

    /**
     * Create Policy Builder by validaton rules
     *
     * @param Array $rules Contain password validation rules
     * 
     * @return PolicyBuilder
     */
    protected function createPolicyBuilder($rules)
    {
        $builder = new PolicyBuilder();    
        if (is_array($rules)) {
            foreach ($rules as $key => $value) {
                switch ($$key) {
                    case 'min_length':
                        $builder->minLength($value); break;
                    case 'max_length':
                        $builder->maxLength($value); break;
                    case 'upper_case':
                        $builder->upperCase($value); break;
                    case 'lower_case':
                        $builder->lowerCase($value); break;
                    case 'digits':
                        $builder->digits($value); break;
                    case 'special_chars':
                        $builder->specialCharacters($value); break;
                    case 'does_not_contain':
                        $builder->doesNotContain($value); break;
                    default:                    
                        break;
                }              
            }
        }
        return $builder;
    }        

    /**
     * Read Password Policy user rules form local driver
     * 
     * @return array
     */
    protected function getLocalDriverUserRules()
    {
        $rules = $this->config->get('radan.password_policy.local.user.rules');
        return $rules;
    }

    /**
     * Read Password Policy default rules form local driver
     * 
     * @return array
     */
    protected function getLocalDriverDefaultRules() 
    {
        $rules = $this->config->get('radan.password_policy.local.default.rules');
        $builder = $this->createPolicyBuilder($rules);        
    }    

    /**
     * Read Password Policy default rules form database driver
     * 
     * @return array
     */
    protected function getDatabaseDriverDefaultRules() 
    {
       $rules = [];
       $policy = PasswordPolicy::where('name','default')->first();       
       if ($policy) {
            $rules = [];
            $rules['min_length'] = $policy->min_length;
            $rules['max_length'] = $policy->max_length;
            $rules['upper_case'] = $policy->upper_case;
            $rules['lower_case'] = $policy->lower_case;
            $rules['digits'] = $policy->digits;
            $rules['special_chars'] = $policy->special_chars;
            $rules['does_not_contain'] = $policy->does_not_contain;
       }
       return $rules;
    }

    /**
     * Read Password Policy user rules form database driver
     * 
     * @return array
     */
    protected function getDatabaseDriverUserRules()
    {
        $rules = [];
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $policy = $user->profileUser->profile->passwordPolicy;
            if ($policy) {
                $rules = [];
                $rules['min_length'] = $policy->min_length;
                $rules['max_length'] = $policy->max_length;
                $rules['upper_case'] = $policy->upper_case;
                $rules['lower_case'] = $policy->lower_case;
                $rules['digits'] = $policy->digits;
                $rules['special_chars'] = $policy->special_chars;
                $rules['does_not_contain'] = $policy->does_not_contain;                
            }
        }
        return $rules;
    }
}
