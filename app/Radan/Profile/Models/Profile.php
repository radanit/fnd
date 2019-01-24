<?php

namespace App\Radan\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model 
{        
    use SoftDeletes;    

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
        'created_at', 'updated_at', 'deleted_at',
    ];  

    /**
     * The method for relationships
     *
     * @var void
     */
    public function userProfiles()
    {
        return $this->hasMany('App\Radan\Profile\Models\UserProfile');
    }

}
