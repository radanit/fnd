<?php

namespace App\Radan\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model 
{        
    use SoftDeletes;    

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