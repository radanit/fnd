<?php 

namespace App\Radan\Policy\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Radan\Policy\Password\Policy;
use App\Radan\Policy\Password\PolicyManager;
use App\Radan\Policy\Password\PolicyBuilder;
use App\Radan\Policy\Password\PasswordPolicyFacade;
use App\Radan\Policy\Password\PasswordValidator;
//use Validator;

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
        // Create singleton password policy manager instance
        $this->app->singleton('policy.manager', function ($app) {
            $policyManager = new PolicyManager();
            
            // get defaut policy name from config
            $defaultName = $this->app['config']->get('password_policy.default_name');
            $validationName = $this->app['config']->get('password_policy.validation_name');
            
            // set PasswordManager default policy and validation name
            $policyManager->setDefaultName($defaultName);
            $policyManager->setValidationName($validationName);
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
     * Using define password policy
     *
     * @return void
     */
    protected function definePolicies()
    {        
        // First try read password policy rules from database
        // get password policy elequent model name form config
        $policyDataModel = $this->app['config']->get('password_policy.models.password_policy');
        
        // Check policy elequent model is exists
        if (class_exists($policyDataModel)) {
            $policies = $policyDataModel::all()->toArray();            
        }
        elseif ($policyData = $this->app['config']->get('password_policy.local_policies')) {
            $policies = $policyData;
        }
           
        foreach ($policies as $rules)  {
            $builder = new PolicyBuilder();
            $policy = $builder->createPolicy($rules);           
            $this->app['policy.manager']->define($rules['name'],$policy);
        }        
    }    
}
