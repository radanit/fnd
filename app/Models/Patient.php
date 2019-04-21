<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Auth\Models\User as AuthUser;

class Patient extends AuthUser
{   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Default model attribute values
     * 
     * @var array
     */
    protected $attributes =[
        'password' => 'password',
    ];    
    
    /**
     * The profile type name used in global scop
     *
     * @var string
     */
    public const PROFILE_TYPE='patient';
    
    /**
     * The user role name used in global scop
     *
     * @var string
     */
	public const ROLE_NAME='patient';
			
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->ofType(self::PROFILE_TYPE);
        });
    }    
        
    /**
     * Relation with receptions
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receptions()
    {
        return $this->hasMany(Reception::class,'national_id','username');
    }

    /**
     * Define Accessor and Matator
     * 
     */
    public function setNationalIdAttribute($value) 
    {
        $this->attributes['username'] = $value;
    }

    public function getNationalIdAttribute() 
    {
        return $this->attributes['username'];
    }
}
