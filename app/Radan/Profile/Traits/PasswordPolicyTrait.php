<?php

namespace App\Radan\Profile\Traits;

/**
 * This file is part of Radan Profile, 
 *
 * @license MIT
 * @package Radan/Profile
 */

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

trait PasswordPolicyTrait
{    
    protected $validationRules = [       
    ];

    /*
     * Make laravel validation rule for number of special characters
     */
    protected function minLenght($count)
    {
        $validationRule = ($count) ? 'min:'.$count : '';
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /*
     * Make laravel validation rule for number of special characters
     */
    protected function maxLenght($count)
    {
        $validationRule = ($count) ? 'max:'.$count : '';
        $this->validationRules[] = $validationRule;
        return $this;
    }    
        
    /*
     * Make laravel validation rule for number of Upper case
     */
    protected function upperCase($count)
    {
        $validationRule = ($count) ? 'regex:/(?=.*?[A-Z]){'.$count.',}/' : 'regex://';
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /*
     * Make laravel validation rule for number of lower case
     */
    protected function lowerCase($count)
    {
        $validationRule = ($count) ? 'regex:/(?=.*?[a-z]){'.$count.',}/' : 'regex://';
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /*
     * Make laravel validation rule for number of lower case
     */
    protected function digits($count)
    {
        $validationRule = ($count) ? 'digits:'.$count : '';
        $this->validationRules[] = $validationRule;
        return $this;
    }
    
    /*
     * Make laravel validation rule for number of special characters
     */
    protected function specialChars($count)
    {
        $validationRule = ($count) ? 'regex:/([!@#$%^&*(),.?":{}|<>]){'.$count.',}/' : 'regex://';
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /*
     * Make laravel validation rule for number of lower case
     */
    protected function doesNotContain($chars)
    {        
        $validationRule = !empty($chars) ? 'not_contains:'.$chars : '';
        $this->validationRules[] = $validationRule;
        return $this;
    }        

    public function makeValidationRule($attribute, $value, $parameters)
    {                    
        // Create validation rule
				$this
            ->minLenght($this->min_length)
            ->maxLenght($this->max_length)
            ->upperCase($this->upper_case)
            ->lowerCase($this->lower_case)
            ->digits($this->digits)
            ->specialChars($this->special_chars)
            ->doesNotContain($this->does_not_contain);
        
        // Create Laravel Validatore and return
       //dd([$attribute => $value]);
        return Validator::make([$attribute => $value],[$attribute => $this->validationRules]);
    }
}
