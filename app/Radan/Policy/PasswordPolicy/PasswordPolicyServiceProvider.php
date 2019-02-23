<?php 

namespace App\Radan\Policy\PasswordPolicy;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * Class PasswordPolicyServiceProvider
 *
 * @package PasswordPolicy\Providers\Laravel
 */
class PasswordPolicyServiceProvider extends ServiceProvider
{
    /**
     * Private provider attribute for handeling IOC configuration object.
     * 
     */ 
    protected $config;
    
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {        
        $this->registerManager();        
        // $this->registerBuilder();
        // $this->registerFacade();
        // $this->defineDefaultPolicy();        
    }    

    /**
     * Boot the service provider
     *
     * @return void
     */
    public function boot(Config $config,Request $request)
    {    
        $this->config = $config;
        dd($request);
        $this->configureValidationRule();
        $this->defineDefaultPasswordPolicy();
        $this->defineUserPasswordPolicy();
    }

    /**
     * Register the policy manager within the Laravel container
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->instance(PolicyManager::class,function ($app) {
            return new PolicyManager();
        });
    }

    /**
     * Register policy builder
     *
     * @return void
     */
    protected function registerBuilder()
    {
        $this->app->bind(PolicyBuilder::class);
    }

    /**
     * Configure custom Laravel validation rule
     *
     * @return void
     */
    protected function configureValidationRule()
    {
        $this->app['validator']->extend('password', PasswordValidator::class . '@validate');
    }

    /**
     * Register password policy facade
     *
     * @return void
     */
    protected function registerFacade()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('PasswordPolicy', Facade::class);
    }

    /**
     * Define the default password policy
     *
     * @return void
     */
    protected function defineDefaultPolicy()
    {
        $defaultPolicy = $this->defaultPolicy($this->app->make(PolicyBuilder::class));

        if ($defaultPolicy instanceof PolicyBuilder) {
            $defaultPolicy = $defaultPolicy->getPolicy();
        }

        $this->app->make(PolicyManager::class)->define('default', $defaultPolicy);
    }

    /**
     * Build the default policy instance
     *
     * @param PolicyBuilder $builder
     *
     * @return \PasswordPolicy\Policy
     */
    protected function defaultPolicy(PolicyBuilder $builder)
    {
        return $builder->getPolicy();
    }

    /**
     * Extend laravel Validation by default Password Policy.
     *
     * @return void
     */
    protected function defineDefaultPasswordPolicy()
    {
        $method = 'get'. $this->getPolicyDriver() . 'DefaultRules';     
        $builder = $this->createPolicyBuilder($this->$method());
        $manager = new PolicyManager();
        $manager->define('default', $builder);
    }

    /**
     * Extend laravel Validation by user Password Policy.
     *
     * @return void
     */
    protected function defineUserPasswordPolicy()
    {
        $method = 'get'. $this->getPolicyDriver() . 'UserRules';
        $builder = $this->createPolicyBuilder($this->$method());
        $manager = new PolicyManager();
        $manager->define('user', $builder);
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
        $builder = new PolicyBuilder(new Policy);
        if (is_array($rules)) {
            foreach ($rules as $key => $value) {
                switch ($key) {
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
        dd(auth()->guard('api')->user());
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            dd($user);
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
        //dd ($rules);
    }
}
