<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Traits\RadanRestrictedRelationTrait;
use App\Radan\Auth\Models\User;

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
    protected const PROFILE_TYPE='patient';
    
    /**
     * The user role name used in global scop
     *
     * @var string
     */
	protected const ROLE_NAME='patient';
		
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
     * Relation with receptions
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receptions()
    {
        return $this->hasMany(Reception::class);
    }
}
