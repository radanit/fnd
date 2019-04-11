<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Fundation\Traits\RadanRestrictedRelationTrait;

class Reception extends Model
{         
    
    use RadanRestrictedRelationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'patient_id', 'radio_type_id', 'reception_status_id','votes',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [    
    ];
   
    /**
     * Relation with patient
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function radioType()
    {
        return $this->belongsTo(RadioType::class);
    }

    public function status()
    {
        return $this->hasMany(ReceptionStatus::class);
    }

    public function lastStatus()
    {
        return $this->status->last();
    }

    public function getLastStatusAttribute()
    {
        return $this->lastStatus()->status;
    }
    
    public function getLastStatusIdAttribute()
    {
        return $this->lastStatus()->id;
    }
}
