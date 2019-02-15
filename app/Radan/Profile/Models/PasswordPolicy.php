<?php

namespace App\Radan\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Radan\Profile\Traits\PasswordPolicyTrait;

class PasswordPolicy extends Model 
{        
    // use SoftDeletes;
    use PasswordPolicyTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'description', 'min_length', 'max_length','upper_case','lower_case','digits','special_chars','does_not_contain'
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
     * Creates a new instance of the model.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('radan.profile.tables.password_policies');
    }

    /**
     * The method for relationships
     *
     * @var void
     */
    public function profiles()
    {        
        return $this->hasMany(
            Config::get('radan.profile.models.profiles'),
            Config::get('radan.profile.foreign_keys.password_policies')
        );
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
