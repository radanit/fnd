<?php

namespace App\Radan\Profile\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Profile extends Model 
{        
    // use SoftDeletes;

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
     * Creates a new instance of the model.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('radan.profile.tables.profiles');
    }

    /**
     * The method for relationships
     *
     * @var void
     */
    public function profileUsers()
    {
        return $this->hasMany(
            Config::get('radan.profile.models.profile_user'),
            Config::get('radan.profile.foreign_keys.profiles')
        );
    }
}
