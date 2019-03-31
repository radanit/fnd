<?php

namespace App\Radan\Auth\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

use App\Radan\Profile\Traits\SetPasswordAccessorTrait;
use App\Radan\Profile\Traits\ProfileUserTrait;
use App\Radan\Profile\Traits\ProfileUserScopeTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;
    use LaratrustUserTrait;
    use SetPasswordAccessorTrait; 
    use ProfileUserTrait;
    use ProfileUserScopeTrait;

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
    /**
     * The method overrides for authenticate with username and email
     *
     * @var array
     */
    public function findForPassport($identifier) {
        return $this->orWhere('email', $identifier)->orWhere('username', $identifier)->first();
    }

}
