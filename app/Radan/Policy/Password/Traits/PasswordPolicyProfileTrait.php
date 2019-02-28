<?php

namespace App\Radan\Policy\PasswordPolicy\Traits;

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
        return $this->hasOne('App\Radan\Policy\PasswordPolicy\PasswordPolicy', 'id', 'password_policy_id');
    }
}