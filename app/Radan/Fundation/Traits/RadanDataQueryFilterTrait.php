<?php

namespace App\Radan\Fundation\Traits;

use Validator;

trait RadanDataQueryFilterTrait
{
    /**
     * Return url filter parameter name
     *
     * @return string
     */
    protected function getFilterName()
    {
        if (isset($this->requestFilterName) and !empty($this->requestFilterName)) {
            return $this->requestFilterName;
        } else {
            return 'filter';
        }
    }

    /**
     * Fetching http url filters
     *
     * @param Illuminate\Http\Request $reqest
     * @return void
     */
    protected function fetchFilters($request)
    {
        if ($request->isMethod('get') and $request->has($this->getFilterName())) {            
            $this->filters = $request->query($this->getFilterName());
        
            $this->filters = (!is_array($this->filters)) ? []: $this->filters;

            if (isset($this->filterable) and is_array($this->filterable) and count($this->filterable)) {
                $allowed = $this->filterable;

                $this->filters = array_filter(
                    $this->filters,
                    function ($key) use ($allowed) {
                        return in_array($key, $allowed);
                    },
                    ARRAY_FILTER_USE_KEY
                );
            }            
        }        
    }

    /**
     * Return if exists url filter parameter
     *
     * @return boolean
     */    
    protected function hasFilter()
    {
        return (isset($this->filters) and count($this->filters));
    }

    /**
     * Return url filters array
     *
     * @return array
     */
    protected function getFilter($key=null)
    {
        if ($this->hasFilter()) {
            return isset($this->filters[$key]) ? $this->filters[$key]: $this->filters;
        } else {
            return null;
        }       
    }

    /**
     * Check filter validations
     *
     * @return array
     */
    protected function validateFilter()
    {        
        if (method_exists($this,'filterRules')) {
            
            $rules = $this->filterRules();            
            Validator::make($this->filters,$rules)->validate();
        }

        return true;
    }
}