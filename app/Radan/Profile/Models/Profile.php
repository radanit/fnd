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

     /**
     * The method for relationships
     *
     * @var void
     */
    public function passwordPolicy()
    {
        return $this->belongsTo(
            Config::get('radan.profile.models.password_policies'),
            Config::get('radan.profile.foreign_keys.password_policies')
        );        
    }
}
