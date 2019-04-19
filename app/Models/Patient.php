<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Auth\Models\User as BaseUser;
use Profile;

class Patient extends BaseUser
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
     * Get parent object 
     * 
     */
    public function user()
    {
        return BaseUser::find();
    }
    
    /**
     * Update or create patient profile
     * 
     * @param array
     */
    public function syncProfile(array $attributes = []) 
    {
        if (isset($attributes)) {
            // Validate profile data
            Profile::set(self::PROFILE_TYPE)->validate($attributes);
            
            // Update or create Profile data       
            if (Profile::has($this)) {
                Profile::update($this,$attributes);
            }
            else {
                Profile::create($this,$attributes);
            }
        }

        return $this;
    }
    
    /**
     * Attache patient role to user 
     * 
     * @param void
     */
    public function syncRole()
    {
        if (!$this->user()->hasRole(self::ROLE_NAME)) {
            $role = Role::where('name',self::ROLE_NAME)->first();
            $this->user()->roles()->attach($role);
        }

        return $this;
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
     * Define Accessors
     * 
     */
    public function setNationalIdAttribute($value) 
    {
        $this->attributes['username'] = $value;
    }
}
