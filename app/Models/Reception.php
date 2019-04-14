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
    ];

    protected $guarded  = [
        'id',
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
        return $this->belongsTo(Patient::class,'national_id','username');
    }

    /**
     * Relation with doctor
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }

    /**
     * Relation with radio types
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function radioType()
    {
        return $this->belongsTo(RadioType::class);
    }

    /**
     * Relation with reception status
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function status()
    {
        return $this->hasMany(ReceptionStatus::class);
    }

    /**
     * Accessor and Mataurs
     * 
     */
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
