<?php

namespace App\Radan\Auth\Models;

use Laratrust\Models\LaratrustRole;
use App\Radan\Traits\RadanًRestrictedRelationTrait;

class Role extends LaratrustRole
{
    use RadanًRestrictedRelationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name', 'description','name',
    ];

    /**
     * The attributes that are use for deleteing restricted
     * come with RadanًRestrictedRelationTrait
     * @var array
     */
    protected $restricteds = [
        'users', 'permissions',
    ];
    
}
