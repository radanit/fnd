<?php

namespace App\Radan\Policy\Password\Traits;

/**
 * This file is part of Radan PasswordPolicy
 *
 * @license MIT
 * @package Radan/PasswordPolicy
 */

trait PasswordPolicyProfileTrait
{    
    /**
     * The method for relationships
     *
     * @var void
     */    
    public function passwordPolicy()
    {
        return $this->belongsTo('App\Radan\Policy\Password\Models\PasswordPolicy', 'id', 'password_policy_id');
    }
}