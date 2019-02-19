<?php

namespace App\Radan\PasswordPolicy\Contracts;

/**
 * This file is part of Radan Profile, 
 *
 * @license MIT
 * @package Radan/PasswordPolicy
 */

interface PolicyDriverContract
{
    /**
     * Return policy by name
     *    
     * @return $policy String
     */
    public function getPolicy();

    /**
     * Return rules
     *    
     * @return $rules String|Array
     */
    public function getRules();

    /**
     * Return deafult policy by name
     *    
     * @return $policy String
     */
    public function getDefaultPolicy();

    /**
     * Return default rules
     *    
     * @return $rules String|Array
     */
    public function getDefaultRules();
}
