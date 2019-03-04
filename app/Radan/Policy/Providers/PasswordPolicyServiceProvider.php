<?php 

namespace App\Radan\Policy\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Radan\Policy\Password\PolicyManager;
use App\Radan\Policy\Password\PolicyBuilder;
use App\Radan\Policy\Password\PasswordPolicyFacade;
use App\Radan\Policy\Password\PasswordValidator;
use Validator;

/**
 * Class PasswordPolicyServiceProvider
 *
 * @package App\Radan\Policy\Password
 */
class PasswordPolicyServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {        
        $this->mergeConfigFrom(
            __DIR__.'/../Password/config/password_policy.php', 'password_policy');
        $this->registerManager();
        $this->registerBuilder();
        $this->registerFacade();        
    }

    /**
     * Boot the service provider
     *
     * @return void
     */
    public function boot(Config $config,Request $request)
    {
        $this->extendValidator();
        $this->definePolicies();
    }

    /**
     * Register the policy manager within the Laravel container
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('policy.manager', function ($app) {
            $policyManager = new PolicyManager();            
            return $policyManager;
        });
    }

    /**
     * Register policy builder
     *
     * @return void
     */
    protected function registerBuilder()
    {        
        $this->app->bind(PolicyBuilder::class, function ($app) {
            return new PolicyBuilder();
        });
    }

    /**
     * Register password policy facade
     *
     * @return void
     */
    protected function registerFacade()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('PasswordPolicy', PasswordPolicyFacade::class);
    }

    /**
     * Using Extensions Laravel validation rule
     *
     * @return void
     */
    protected function extendValidator()
    {        
        $this->app['validator']->extend(
            $this->app['config']->get('password_policy.validation_name'),
            PasswordValidator::class . '@validate'
        );        
    }
    
    /**
     * Using Extensions Laravel validation rule
     *
     * @return void
     */
    protected function definePolicies()
    {        
        $policyDataModel = $this->app['config']->get('password_policy.models.password_policies');        
        if ($policyData = new $policyDataModel()) {
            $policies = $policyData::all()->toArray();            
        }
        elseif ($policyData = $this->app['config']->get('password_policy.local_policies')) {
            $policies = $policyData;
        }

        //PasswordPolicy::define($policies);
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
