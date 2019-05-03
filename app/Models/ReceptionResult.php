<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Fundation\Traits\RadanRestrictedRelationTrait;
use App\Radan\Fundation\Traits\RadanUserStampTrait;

class ReceptionResult extends Model
{
    use RadanRestrictedRelationTrait;
    
    use RadanUserStampTrait;
    public function userstamp() {
		return [
            'create' => 'created_by',  
		];
    }    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reception_results';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'reception_id', 'result', 'created_by',
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
    public function reception()
    {
        return $this->belongsTo(Reception::class);
    }
}
