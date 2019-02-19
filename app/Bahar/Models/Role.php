<?php

namespace App\Bahar\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Traits\RadanًRestrictedRelationTrait;
use App\Radan\Auth\Models\Role as RadanRole;

class Role extends RadanRole
{
    /**
     * The method manage relation with Role Model
     *
     * @var array
     */      
    function radioTypes()
    {
        return $this->belongsTo(RadioType::class, 'id', 'role_id');
    }   
}
