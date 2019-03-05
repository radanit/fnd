<?php

namespace App\Radan\Policy\Password\Traits;

/**
 * This file is part of Radan PasswordPolicy
 *
 * @license MIT
 * @package Radan/PasswordPolicy
 */

use Illuminate\Support\Facades\Config;

trait PasswordPolicyProfileTrait
{    
    /**
     * The method for relationships
     *
     * @var void
     */    
    public function passwordPolicy()
    {
        return $this->belongsTo(
            Config::get('password_policy.models.password_policy'),
            Config::get('password_policy.foreign_keys.password_policy'),
            Config::get('password_policy.foreign_keys.profile')
        );            
    }
}