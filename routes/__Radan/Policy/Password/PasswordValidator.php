<?php 

namespace App\Radan\Policy\Password;

/**
 * Class PasswordValidator
 *
 * @package PasswordPolicy\Providers\Laravel
 */

use PasswordPolicy;
class PasswordValidator
{
    /**
     * Policy manager instance
     *
     * @var PolicyManager
     */

    /**
     * Validate the given value
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     *
     * @return bool
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        // Use the default policy if the user has not specified one.
        $policy = isset($parameters[0]) ? $parameters[0] : PasswordPolicy::getDefaultName();        
        return PasswordPolicy::
            validator($policy)
            ->attempt($value);
    }
}