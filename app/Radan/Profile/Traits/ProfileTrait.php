<?php

namespace App\Radan\Profile\Traits;

/**
 * This file is part of Radan Profile, 
 *
 * @license MIT
 * @package Radan/Profile
 */

use Illuminate\Http\Request;

trait ProfileTrait
{
    protected function profileValidate($profile,$request) 
    {                
        // Get profile structure, 
        // Check if Model casting JSON to Array does not work, JSON to Array manualy
        $structure = (is_array($profile->structure)) ? $profile->structure:json_decode($profile->structure);

        // Define validation eules Array
        $rules = [];
        
        // Check profile structure items
        foreach ($structure as $item) 
        {
            if (is_array($item)) {
                $rule = array_key_exists('rules',$item) ? $item['rules'] : '';
                if (array_key_exists('name',$item)) {
                    $rules[$item['name']] = $rule;
                }

            }                        
        }
        
        

        dd($rules);
    }
}
