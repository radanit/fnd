<?php

namespace App\Radan\Profile\Traits;

/**
 * This file is part of Radan Profile, 
 *
 * @license MIT
 * @package Radan/Profile
 */

use Illuminate\Http\Request;
use Validator;

trait ProfileTrait
{
    protected function castJsonToCollect($structure)
    {
        $structure = (is_array($structure)) ? $structure : json_decode($structure);
        $collection =  collect($structure)->map(function($row) {
            return collect($row);
        });
        return $collection;
    }    

    protected function getProfileFields($structure,$key='',$value='')
    {
        $fields = [];
        $structure = $this->castJsonToCollect($structure);
        // Check profile structure items
        foreach($structure as $item) {            
            $fields[$item->get($key)] = $item->get($value);            
        }

        return $fields;
    }
    
    protected function profileValidate($profile,$request) 
    {
        // Define validation eules Array
        $rules = $this->getProfileFields($profile->structure,'name','rules');
        $fields = array_keys($rules);

        // run validation
        Validator::make($request->only($fields),$rules)->validate();
        return true;
    }

    protected function saveProfile($profile,$request)
    {
        $fieldTypes = $this->getProfileFields($profile->structure,'name','type');
        $fields = array_keys($fieldTypes);        
        $profileData = $request->only($fields);
        dd($profileData);

        foreach ($request->only($fields) as $key => $value)
        {
            if ($fieldTypes[$key] == 'file') {

            }            
        }

       
    }
}
