<?php

namespace App\Radan\Traits;

/**
 * This file is part of Radan, 
 *
 * @license MIT
 * @package Radan/Traits
 */

trait RadanSetPasswordAccessorTrait
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
