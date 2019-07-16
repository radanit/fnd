<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;
use App\Radan\Fundation\Traits\RadanRestrictedRelationTrait;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class Reception extends Model
{
    use Mediable;
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
     * Scope a query to include reception when last status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
	public function scopeWhereStatus(Builder $builder, $names)
	{
        //return $query->with('lastStatus')->get()->where('lastStatus.status',$status);
        $names = is_array($names) ? $names: [$names];
        $builder->whereHas('status', function (Builder $query) use ($names) {
            $query
                ->whereIn('status', $names)
                ->whereIn(
                    'id',
                    function (QueryBuilder $query) {
                        $query
                            ->select(DB::raw('max(id)'))
                            ->from('reception_status')                                
                            ->groupBy('reception_id');
                    }
                );
            }
        );		
		
    }
   
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
	
	public function lastStatus()
    {
        return $this->hasOne(ReceptionStatus::class)->latest();
    }        

    /**
     * Relation with reception status
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany(ReceptionResult::class);
    }

    public function lastResult()
    {
        return $this->hasOne(ReceptionResult::class)->latest();
    }
}
