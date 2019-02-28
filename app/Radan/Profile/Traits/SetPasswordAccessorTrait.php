<?php

namespace App\Radan\Profile\Traits;

/**
 * This file is part of Radan, 
 *
 * @license MIT
 * @package Radan/Traits
 */

trait SetPasswordAccessorTrait
{
    /**
     * Get the user's full name.
     *
     * @return string
     */
		public function setPasswordAttribute($value)
		{
			$this->attributes['password'] = bcrypt($value);
		}
}
