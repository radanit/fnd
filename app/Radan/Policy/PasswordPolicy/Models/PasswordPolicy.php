<?php

namespace App\Radan\Policy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Config\Repository as Config;

class PasswordPolicy extends Model 
{        

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'description',
        'min_length',
        'max_length',
        'upper_case',
        'lower_case',
        'digits',
        'special_chars',
        'does_not_contain'
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
        'min_length' => 'integer',
        'max_length' => 'integer',
        'upper_case' => 'integer',
        'lower_case' => 'integer',
        'digits' => 'integer',
        'special_chars' => 'integer',
    ];    

    /**
     * The method for relationships
     *
     * @var void
     */    
    public function profiles()
    {
        return $this->belongsTo('App\Radan\Profile\Models\Profile', 'id', 'password_policy_id');
    }


    /**
     * Get the max length attribute Accessore
     *
     * @return string
     */
    public function getMaxLengthAttribute($value)
    {
        return  ($value < $this->min_length) ? $this->min_length:$value;
    }
}
