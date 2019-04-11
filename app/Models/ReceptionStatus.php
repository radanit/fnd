<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Radan\Fundation\Traits\RadanRestrictedRelationTrait;
use App\Radan\Fundation\Traits\RadanUserStampTrait;

class ReceptionStatus extends Model
{             
    use RadanRestrictedRelationTrait;
    
    use RadanUserStampTrait;
    public function userstamp() {
		return [
            'create' => 'created_by',  
		];
    }

    /**
     * Status codes
     * 
     */
    public  const RECEPTING = 'recepting';
    public  const RECEPTED = 'recepted';
    public  const CONFIRMED = 'confirmed';
    public  const REJECTED = 'rejected';

    /**
     * Alias of status codes
     */
    public const FIRST = self::RECEPTING;
    public const LAST = self::CONFIRMED;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reception_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'reception_id', 'status', 'created_by',
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
