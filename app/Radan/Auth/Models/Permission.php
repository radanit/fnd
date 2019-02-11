<?php

namespace App\Radan\Auth\Models;

use Laratrust\Models\LaratrustPermission;
use App\Radan\Traits\RadanًRestrictedRelationTrait;
use App\Radan\Exceptions\ResourceRestricted;

class Permission extends LaratrustPermission
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
     *
     * @var array
     */
    protected $restricteds = [
        'users', 'roles',
    ];
}
