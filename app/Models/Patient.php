<?php

namespace App\Bahar\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Traits\RadanRestrictedRelationTrait;
use App\Radan\Auth\Models\User;

class Patient extends User
{         
    /**
     * The attributes that are use for deleteing restricted
     * come with RadanًRestrictedRelationTrait.
     * On deleting this mode instance , check restricted array
     * to have relation with this model.
     * @var array
     */
    protected $restricteds = [
        //'receptions',
    ];

    use PasswordPolicyProfileTrait;
    use RadanGetTableNameTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'description', 'structure',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [    
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'structure' => 'array',
    ];

    /**
     * Creates a new instance of the model.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('profile.tables.profile');
    }

    /**
     * The method for relationships
     *
     * @var void
     */
    public function users()
    {
        return $this->hasMany(
            Config::get('profile.models.profile_user'),
            Config::get('profile.foreign_keys.profile')
        );
    }     
}
