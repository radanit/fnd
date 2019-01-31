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
    public function userProfile()
    {
        $userProfile = $this->hasOne(
            Config::get('radan.profile.models.user_profile'));

        return $userProfile;
    }
}
