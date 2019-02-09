<?php

namespace App\Radan\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class ProfileUser extends Model 
{

   //use SoftDeletes;    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [        
    ]; 

    //
    protected $fillable = [
        'user_id','profile_id', 'data'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
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
        $this->table = Config::get('radan.profile.tables.profile_user');
    }

    /**
     * The method for relationships
     *
     * @var void
     */
    public function user()
    {
        // return $this->belongsTo('App\Radan\Auth\Models\User');

        return $this->belongsTo(
            Config::get('radan.profile.models.user'),
            Config::get('radan.profile.foreign_keys.user')
        );
    }

    public function profile()
    {
       // return $this->belongsTo('App\Radan\Profile\Models\Profile');  
        return $this->belongsTo(
            Config::get('radan.profile.models.profiles'),
            Config::get('radan.profile.foreign_keys.profiles')
        );  
    }

}
