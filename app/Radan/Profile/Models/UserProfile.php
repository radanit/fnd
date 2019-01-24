<?php

namespace App\Radan\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model 
{

    use SoftDeletes;

    protected $table = 'user_profile';

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
    public function user()
    {
        return $this->belongsTo('App\Radan\Auth\Models\User');
    }

    public function profile()
    {
       return $this->belongsTo('App\Radan\Profile\Models\Profile');        
    }

}
