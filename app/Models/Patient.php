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
        $attributes['username'] = $attributes['national_id'];
        $attributes['password'] = str_random(6);
        $model = static::query()->create($attributes);
        
        // Create Profile data       
        Profile::create($model,$attributes);
        
        // Attache role
        $role = Role::where('name',self::ROLE_NAME);
        $model->attachRoles($role);

        return $model;
    }

    /**
     * Override firstOrCreate method
     * 
     * @return Model
     */
    public static function firstOrCreate(array $attributes = [])
    {
        $model = static::query()->where('username',$attributes['national_id']);
        
        if ($model->get()->count())  {
            return $model->first();
        }
        else {
            return static::create($attributes);
        }
    }

    /**
     * Override update method
     * 
     * @return Model
     */
    public function update(array $attributes = [],array $options = [])
    {
        // Validate profile data
        Profile::set(self::PROFILE_TYPE)->validate($attributes);

        // Create Parent
        if (isset($attributes['national_id'])) {
            $attributes['username'] = $attributes['national_id'];
        }
        $model = $this->query()->update($attributes,$options);
        
        // Create Profile data       
        Profile::update($model,$attributes);

        return $model;
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
