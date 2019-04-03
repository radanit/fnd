<?php

namespace App\Radan\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Radan\Policy\Password\Traits\PasswordPolicyProfileTrait;
use App\Radan\Fundation\Traits\RadanGetTableNameTrait;

class Profile extends Model 
{            
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
