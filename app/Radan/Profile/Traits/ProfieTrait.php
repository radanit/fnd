<?php

namespace App\Radan\Profile\Traits;

/**
 * This file is part of Radan Profile, 
 *
 * @license MIT
 * @package Radan/Profile
 */

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

use App\Radan\Profile\Models\ProfileUser;

trait ProfileTrait
{
    protected function profileValidate($profileId,ProfileUser $profile) {

        $profile = Profile::findOrFail($profileId);
        $structure = (is_array($profile->structure)) ? $profile->structure:json_decode($profile->structure);
        foreach ($structure as $field) {
            
        }
        

    }
}
