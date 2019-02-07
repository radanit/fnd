<?php

namespace App\Radan\Auth\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name', 'description',
    ];
}
