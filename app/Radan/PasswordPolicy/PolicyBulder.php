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

class PolicyBuilder
{    
    protected $validationRules = [
    ];

   // protected $config = '';
   // protected $validator = '';

    //public function __constract(Config $config,Validatore $validate)
    public function __constract($ruls = null)
    {        
        $this->validationRules = is_null($ruls) ? []:$ruls;
    }

    /*
     * Make laravel validation rule for number of special characters
     */
    public function minLenght($count)
    {
        $validationRule = ($count) ? 'min:'.$count : '';
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /*
     * Make laravel validation rule for number of special characters
     */
    public function maxLenght($count)
    {
        $validationRule = ($count) ? 'max:'.$count : '';
        $this->validationRules[] = $validationRule;
        return $this;
    }    
        
    /*
     * Make laravel validation rule for number of Upper case
     */
    public function upperCase($count)
    {
        $validationRule = ($count) ? 'regex:/(?=.*?[A-Z]){'.$count.',}/' : 'regex://';
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /*
     * Make laravel validation rule for number of lower case
     */
    public function lowerCase($count)
    {
        $validationRule = ($count) ? 'regex:/(?=.*?[a-z]){'.$count.',}/' : 'regex://';
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /*
     * Make laravel validation rule for number of lower case
     */
    public function digits($count)
    {
        $validationRule = ($count) ? 'digits:'.$count : '';
        $this->validationRules[] = $validationRule;
        return $this;
    }
    
    /*
     * Make laravel validation rule for number of special characters
     */
    public function specialChars($count)
    {
        $validationRule = ($count) ? 'regex:/([!@#$%^&*(),.?":{}|<>]){'.$count.',}/' : 'regex://';
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /*
     * Make laravel validation rule for number of lower case
     */
    public function doesNotContain($chars)
    {        
        $validationRule = !empty($chars) ? 'not_contains:'.$chars : '';
        $this->validationRules[] = $validationRule;
        return $this;
    } 
    
    /*
     * Make laravel validation rule for password confirmed
     */
    public function withConfirmed()
    {
        $validationRule = 'confirmed';
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /*
     * Make laravel validation rule for password confirmed
     */
    public function withRequired()
    {
        $validationRule = 'required';
        $this->validationRules[] = $validationRule;
        return $this;
    }

    public function getRules()
    {
        return $this->validationRules;
    }
    
    public function setRules($ruls)
    {
       $this->validationRules = $ruls;
       return $this;
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
