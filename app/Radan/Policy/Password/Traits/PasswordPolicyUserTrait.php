<?php

namespace App\Radan\Policy\Password\Traits;

/**
 * This file is part of Radan PasswordPolicy
 *
 * @license MIT
 * @package Radan/PasswordPolicy
 */

use PasswordPolicy;

trait PasswordPolicyUserTrait
{    
    /**
     * The method for relationships
     *
     * @var void
     */    
    public function passwordPolicy()
    {
        return PasswordPolicy::getValidation(
            $this->profile->type->name
        );           
    }
}