<?php

namespace App\Radan\Fundation\Traits;

/**
 * This file is part of Radan, 
 *
 * @license MIT
 * @package Radan/Traits
 */
use App\Radan\RequestFilter;

trait RadanRequestFilter
{   
    /**
     * Provide filter request befor validation
     * 
     * @return void
     */
    protected function beforFilter() 
    {
        // filter http request
        $this->filter($this->beforFilter);        
    }

    /**
     * Provide filter request after validation
     * 
     * @return void
     */
    protected function afterFilter() 
    {
        // filter http request       
        $this->filter($this->afterFilter);               
    }

    /**
     * Apply befor or after filter
     * 
     * @param array $filter array pair of request and filter rules
     * @return array
     */
    protected function filter($filters) 
    {
        // Check if $filter is array
        if (is_array($filters)) 
        {
            // Iterate filters
            foreach ($filters as $key => $filter) 
            {
                RequestFilter::apply($this->request,$key,$filter);
            }
        }        
    }

    /**
     * Override: Illuminate\Validation\ValidatesWhenResolvedTrait
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        /** override in this point **/ 
        $this->beforFilter();
    }

    /**
     * Override: Illuminate\Validation\ValidatesWhenResolvedTrait
     * Validate the class instance.
     *
     * @return void
     */
    public function validateResolved()
    {
        $this->prepareForValidation();

        if (! $this->passesAuthorization()) {
            $this->failedAuthorization();
        }

        $instance = $this->getValidatorInstance();

        if ($instance->fails()) {
            $this->failedValidation($instance);
        }

        /** override in this point **/
        $this->afterFilter();
    }
    
}
