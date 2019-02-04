<?php

namespace App\Radan\Auth\Models;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    //
    protected $fillable = [
        'name', 'desciption'
    ];
}
