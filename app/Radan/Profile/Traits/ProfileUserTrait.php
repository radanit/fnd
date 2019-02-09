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
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $profileUserData = $this->profileUser->first()->data;
        $name = (array_key_exists('name',$profileUserData)) ? $profileUserData['name'] : '';
        $family = (array_key_exists('family',$profileUserData)) ? $profileUserData['family'] : '';
        return trim("{$name} {$family}");
    }

    /**
     * One-to-One relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\OneToOne
     */
    public function profileUser()
    {
        $profileUser = $this->hasOne(
            Config::get('radan.profile.models.profile_user'),
            Config::get('radan.profile.foreign_keys.user'),
            $this->primaryKey
        );

        return $profileUser;
    }
}
