<?php

namespace App\Bahar\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Traits\RadanRestrictedRelationTrait;
use App\Radan\Auth\Models\User;

class Doctor extends User
{         
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
}
