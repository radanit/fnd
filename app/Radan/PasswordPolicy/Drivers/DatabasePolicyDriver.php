<?php

namespace App\Radan\PasswordPolicy\Drivers;

/**
 * This file is part of Radan Profile, 
 *
 * @license MIT
 * @package Radan/Profile
 */

use Illuminate\Support\Facades\Config;
use App\Radan\PasswordPolicy\Contracts\PolicyDriverContract;
use App\Radan\PasswordPolicy\Models\PasswordPolicy;

class DatabasePolicyDriver implements PolicyDriverContract
{
    protected $config;
    protected $policy;

    public function __constract(PasswordPolicy $policy)
    {
        //$this->config = $config;
        $this->policy = $policy;
    }    
    
    /**
     * Return policy by name
     *    
     * @return $policy String
     */
    public function getPolicy($name='')
    {
        if (empty($name)) {
            $policy = $this->policy()->get();
        } else {
            $policy = $this->policy->where('name',$name)->first();
        }
        return $policy;
    }

    /**
     * Return rules
     *    
     * @return $rules String|Array
     */
    public function getRules()
    {        
        $rules = $this->policy()->first()->get([
                'min_length','max_length','upper_case','lower_case','digits','special_chars'
            ])->map(function($rule) {
                return array_values($rule->toArray());
        });
        return $rules;
    }

    /**
     * Return deafult policy by name
     *    
     * @return $policy String
     */
    public function getDefaultPolicy() 
    {
        $policy = $this->policy->where('name','default')->first()->name;
        return $policy;
    }

    /**
     * Return default rules
     *    
     * @return $rules String|Array
     */
    public function getDefaultRules()
    {
        $rules = $this->policy->where('name','default')->first()->get([
                'min_length','max_length','upper_case','lower_case','digits','special_chars'
            ])->map(function($rule) {
            return array_values($rule->toArray());
        });
        return $rules;
    }    
}
