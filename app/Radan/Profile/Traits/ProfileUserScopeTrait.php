<?php

namespace App\Radan\Profile\Traits;

/**
 * This file is part of Radan Profile, 
 *
 * @license MIT
 * @package Radan/Profile
 */


trait ProfileUserScopeTrait
{
	/**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
	
	/**
     * Scope a query to only include users of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
	public function scopeOfType($query, $type)
	{
		return $query->whereHas('profile', function ($q) use ($type) {
			$q->whereHas('type', function($q) use ($type) {
				$q->where('profiles.name', '=', $type);
			});
		});
	}
}
