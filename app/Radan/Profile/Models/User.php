<?php

namespace App\Radan\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Traits\LaratrustUserTrait;
use App\Radan\Profile\Traits\SetPasswordAccessorTrait;
use App\Radan\Profile\Traits\ProfileUserTrait;


class User extends Model
{    
    use SoftDeletes;
    use LaratrustUserTrait;
    use SetPasswordAccessorTrait; 
    use ProfileUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password','active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];
}
