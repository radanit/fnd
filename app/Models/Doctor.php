<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Auth\Models\User;
use App\Models\Speciality;
use Profile;

class Doctor extends User
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
    protected const PROFILE_TYPE='doctor';
    
    /**
     * The user role name used in global scop
     *
     * @var string
     */
	protected const ROLE_NAME='doctor';		
        
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
     * Override create method
     * 
     * @return Model
     */
    public static function create(array $attributes = [])
    {
        // Validate profile data
        Profile::set(self::PROFILE_TYPE)->validate($attributes);

        // Create Parent
        $model = static::query()->create($attributes);
        
        // Create Profile data
        Profile::create($model,$attributes);
        
        // Attache role
        $role = Role::where('name',self::ROLE_NAME);
        $model->attachRoles($role);

        return $model;
    }

    /**
     * Define speciality matator for this model
     * 
     * @return string
     */
    public function getSpecialityDescAttribute()
    {
        if ($speciality = Speciality::find($this->speciality))
            return $speciality->description;
    }				  	    
}
