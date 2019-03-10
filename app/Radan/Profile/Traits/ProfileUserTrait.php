<?php

namespace App\Radan\Profile\Traits;

/**
 * This file is part of Radan Profile, 
 *
 * @license MIT
 * @package Radan/Profile
 */

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait ProfileUserTrait
{
    /**
     * One-to-One relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\OneToOne
     */
    public function profile()
    {
        $profile = $this->hasOne(
            Config::get('radan.profile.models.profile_user'),
            Config::get('radan.profile.foreign_keys.users'),
            $this->primaryKey
        );

        return $profile;
    }    
    
    /**
     * 
     * Add profile data as attribute accessor by
     * override __get() magic methos of elequent model.
     * 
     * @return mixed
     */
    public function __get($key)    
    {
        if (!property_exists($this, $key) and !method_exists($this, $key))
        {            
            $profileData = (is_array($this->profile->data)) ? $this->profile->data : json_decode($this->profile->data);
            if (array_key_exists($key,$profileData)) {
                return $profileData[$key];
            }
        }
                
        return parent::__get($key);        
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $profileData = $this->profile->data;
        if (is_array($profileData)) {
            $first_name = (array_key_exists('first_name',$profileData)) ? $profileData['first_name'] : '';
            $last_name = (array_key_exists('last_name',$profileData)) ? $profileData['last_name'] : '';
            return trim("{$first_name} {$last_name}");
        }
        else {
            return null;
        }
    }

    public function getTypeAttribute()
    {
        return $this->profile->type->name;
    }

    public function getTypeIdAttribute()
    {
        return $this->profile->type->id;
    }

    public function getTypeDescriptionAttribute()
    {
        return $this->profile->type->description;
    }
}
