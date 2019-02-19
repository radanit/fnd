<?php

namespace App\Radan\PasswordPolicy;

/**
 * This file is part of Radan Profile, 
 *
 * @license MIT
 * @package Radan/Profile
 */

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Closure;

class PolicyManager
{    
    /*
     * Protected attribute for inject system config object
     */
    protected $config;
    
    /*
     * Protected attribute for read base component configuration
     */
    protected $configBase = 'radan.password_policy';

    /*
     * Protected attribute set default laravel validation name
     */
    protected $defaultValidationName = 'password';
    
    /*
     * Protected attribute set default laravel validation name attribute 
     * like defaultValidationName:default
     */
    protected $defaultPolicyName = 'default';

    /*
     * Protected attribute set laravel validation name
     */
    protected $validationName = '';
    
    /*
     * Protected attribute set laravel validation name attribute like defaultValidationName:default
     */
    protected $policyName = '';
    
    
    public function __constract(Config $config,PasswordPolicy $policy)
    {        
        $this->builder =$builder;        

        if (!is_null($config)) {
            $this->config = $config->get($this->configBase);
            $this->defaultValidationName = $config->get(
                'default_validation_name',
                $this->defaultValidationName
            );

            $this->defaultPolicyName = $config->get(
                'default_policy_name',
                $this->defaultPolicyName
            );
        }

    }

    public static function getPolicy()
    {
        $policy = (empty($this->policyName)) ? $this->validationName : $this->validationName.':'.$this->policyName;
        return $policy;
    }

    public static function getDefaultPolicy()
    {
        return self::defaultValidationName().':'.self::defaultPolicyName();
    }

    /**
     * Define a new policy by name
     *
     * @param $name string
     * @param $policy PolicyBuilder|Closure
     *
     * @return $this
     */
    public static function define($name = '',$policy = null)
    {


    }
    /*
    public function makeValidationRule($attribute, $value, $parameters)
    {                    
        // Get Password Policy feature status form config
        $usePasswordPolicyFeature = Config::get('radan.profile.use_password_policy',false);

        // Create validation rule
        if ( $usePasswordPolicyFeature) {
            // Password Policy feature is enable.
            $this
            ->minLenght($this->min_length)
            ->maxLenght($this->max_length)
            ->upperCase($this->upper_case)
            ->lowerCase($this->lower_case)
            ->digits($this->digits)
            ->specialChars($this->special_chars)
            ->doesNotContain($this->does_not_contain)
            ->withConfirmed();
        } else {
            // Password Policy feature is disable.
            $validationRule = Config::get('radan.profile.password_policy_default','');
        }
        
        // Create Laravel Validatore and return       
        return Validator::make([$attribute => $value],[$attribute => $this->validationRules]);
    }
    */
}
