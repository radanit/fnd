<?php

namespace App\Radan\Fundation\Traits;

/**
 * This file is part of Radan, 
 *
 * @license MIT
 * @package Radan/Traits
 */

use App\Radan\Fundation\Exceptions\ResourceRestricted;

trait RadanRestrictedRelationTrait
{
    /*
    |--------------------------------------------------------------------------
    | Define deleting event for checking restricted relation.
    |--------------------------------------------------------------------------
    | If this trait use in model, then deleting event check protected propeties
    | "restricted", then check for model instance relations, and if count of 
    | model relation instance greather than zero, raise ResourceRestricted 
    | Exception.
    |
    */   

    public function delete()
    {        
        if (property_exists($this, 'restricteds')) {
            $relationMethods = $this->restricteds;
            if (is_array($relationMethods)) {
                foreach ($relationMethods as $relationMethod) {                    
                    if ($this->$relationMethod()->count() > 0) {
                        throw new ResourceRestricted;
                    }
                }
            }
        }
        return parent::delete();
    }

}
