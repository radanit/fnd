<?php

namespace App\Radan\Traits;

/**
 * This file is part of Radan, 
 *
 * @license MIT
 * @package Radan/Traits
 */

trait RadanRequestFilter
{
    /**
     * Provide filter request befor validation
     * 
     * @return void
     */
    protected function beforFilter() 
    {
        // Cast user data
        $newData = $this->filter($this->beforFilter);

        // Change Request parameters by casting data        
        $this->mergeRequest($newData);
    }

    /**
     * Provide filter request after validation
     * 
     * @return void
     */
    protected function afterFilter() 
    {
        // Cast user data        
        $newData = $this->filter($this->afterFilter);
        
        // Change Request parameters by casting data        
        $this->mergeRequest($newData);
    }

    /**
     * Request casting by filter
     * 
     * @return void
     */
    protected function mergeRequest($data) 
    {
        // Change Request parameters by casting data
        if (is_array($data))
            $this->request->replace(array_merge($this->request->all(), $data));
    }

    /**
     * Apply befor or after filter
     * 
     * @param array $filter array pair of request and filter rules
     * @return array
     */
    protected function filter($filters) 
    {        
        if (is_array($filters)) {
            $dataFilter = [];
            foreach ($filters as $key => $filter) {
                $value = $this->request->get($key);
                switch ($filter) {
                    case 'array': 
                        $dataFilter[$key] = json_decode($value,true);
                        if (!is_array($dataFilter[$key])) $dataFilter[$key] = (array) $dataFilter[$key];
                        break;
                    case 'json':
                        $dataFilter[$key] = json_encode($value);
                        break;
                    case 'boolean':
                        $dataFilter[$key] = (bool) $value;
                        break;
                    case 'unsetIfNull':
                        if (!empty($value)) break;
                    case 'remove':                        
                        $this->request->remove($key);
                        break;
                    default:
                        $dataFilter[$key] = $filter;
                }
            }
        }
        
        return $dataFilter;       
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
