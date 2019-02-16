<?php

namespace App\Radan\PasswordPolicy\Traits;

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
            Config::get('radan.password_policy.models.password_policies'),
            Config::get('radan.password_policy.foreign_keys.password_policies')
        );        
    }
}