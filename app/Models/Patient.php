<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Auth\Models\User;
use Profile;

class Patient extends User
{   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    
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
	protected const ROLE_NAME='patient';
			
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

    public function updateMeta(array $attributes = []) 
    {
        if (isset($attributes))
        {
            // Validate profile data
            Profile::set(self::PROFILE_TYPE)->validate($attributes);
            
            // Update or create Profile data       
            if (Profile::has($this)) {
                Profile::update($this,$attributes);
            }
            else {
                Profile::create($this,$attributes);
            }

            if (!$this->hasRole(self::ROLE_NAME))
            {
                $role = Role::where('name',self::ROLE_NAME);
                $this->attachRoles($role);
            }
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
