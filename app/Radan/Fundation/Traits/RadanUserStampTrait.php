<?php

namespace App\Radan\Fundation\Traits;

/**
 * This file is part of Radan, 
 *
 * @license MIT
 * @package Radan/Traits
 */

trait RadanUserStampTrait
{
    /**
     * Should be Impeliment in Model
     * @sample
     * public function userstamp() {
	 *	return [
     *        'create' => 'created_by',
     *        'update' => 'updated_by',
     *        'delete' => 'deleted_by'
	 *	];
	 * }
     * 
     * 
     */
    abstract public function userstamp(): array;
    
    public static function bootRadanUserStampTrait()
    {        
        $userId = auth()->id();
        $userId = isset($userId) ? $userId:0;

        // Create new record
        static::creating(function ($model) use ($userId) {            
            $setting = $model->userstamp();            
            if (isset($setting['create'])) {                
                $model->{$setting['create']} = $userId;
            }
        });

        // Update record
        static::updating(function ($model) use ($userId) {            
            $setting = $model->userstamp();
            if (isset($setting['update'])) {                
                $model->{$setting['update']} = $userId;
            }
        });        
    }
}
