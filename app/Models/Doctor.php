<?php

namespace App\Bahar\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Traits\RadanRestrictedRelationTrait;
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
     * The profile type name use in global scop
     *
     * @var string
     */
	protected const PROFILE_TYPE='doctor';		
		
	/**
     * The attributes that are use for deleteing restricted
     * come with RadanًRestrictedRelationTrait.
     * On deleting this mode instance , check restricted array
     * to have relation with this model.
     * @var array
     */
    protected $restricteds = [
        'receptions',
    ];		
        
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

        // Create user
        $user = User::create($attributes);
        Profile::create($user,$attributes);
        
        //$model = static::query()->create($attributes);

        // ...

        return $model;
    }

    /**
     * Define speciality matator for this model
     * 
     * @return string
     */
    public function getSpecialityAttribute()
    {
        return Speciality::find($this->specility_id)->description;
    }
				  		
    
}
