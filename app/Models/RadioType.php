<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Radan\Fundation\Traits\RadanRestrictedRelationTrait;

class RadioType extends Model
{
    use RadanRestrictedRelationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description','name','role_id'
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
    function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
