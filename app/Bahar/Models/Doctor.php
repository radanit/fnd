<?php

namespace App\Bahar\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Traits\RadanRestrictedRelationTrait;

class Doctor extends Model
{
    
    
    
    use RadanRestrictedRelationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','speciality_id'
    ];

    /**
     * The attributes that are use for deleteing restricted
     * come with RadanًRestrictedRelationTrait.
     * On deleting this mode instance , check restricted array
     * to have relation with this model.
     * @var array
     */
    protected $restricteds = [
        //'receptions',
    ];

    /**
     * The method manage relation with Role Model
     *
     * @var array
     */
    function speciality()
    {
        return $this->hasOne(Speciality::class, 'id', 'speciality_id');
    }

}
