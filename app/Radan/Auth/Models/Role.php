<?php

namespace App\Radan\Auth\Models;

use Laratrust\Models\LaratrustRole;
use App\Radan\Traits\RadanRestrictedRelationTrait;

class Role extends LaratrustRole
{
    use RadanRestrictedRelationTrait;

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
     * come with RadanًRestrictedRelationTrait.
     * On deleting this mode instance , check restricted array
     * to have relation with this model.
     * @var array
     */
    protected $restricteds = [
        'users',
    ];
    
}
