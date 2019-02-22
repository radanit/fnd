<?php

namespace App\Bahar\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Traits\RadanRestrictedRelationTrait;
use App\Radan\Auth\Models\Role as RadanRole;

class Role extends RadanRole
{
    use RadanRestrictedRelationTrait;
    
    /**
     * The method manage relation with RadioType Model
     *
     * @var array
     */
    function radioTypes()
    {
        return $this->belongsTo(RadioType::class, 'id', 'role_id');
    }

}
