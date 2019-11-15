<?php

namespace App\Radan\Fundation\Traits;

use Validator;

trait RadanDataQueryOrderTrait
{
    protected $orderDelimeterChar = ',';

    /**
     * Return url order parameter name
     *
     * @return string
     */
    protected function getOrderName()
    {
		if (isset($this->requestOrderName) and !empty($this->requestOrderName)) {
			return $this->requestOrderName;
		} else {
			return 'sort';
		}
    }

    /**
     * Fetching http url Orders
     *
     * @param Illuminate\Http\Request $reqest
     * @return void
     */
    protected function fetchOrders($request)
    {
        if ($request->isMethod('get') and $request->has($this->getOrderName())) {            
            $this->orders = explode($this->orderDelimeterChar,$request->query($this->getOrderName()));
			
			// Fetch allow orders
            if (isset($this->orderable) and is_array($this->orderable) and count($this->orderable)) {
                $allowed = $this->orderable;

                $this->orders = array_filter(
                    $this->orders,
                    function ($key) use ($allowed) {
                        return in_array($key, $allowed);
                    },
                    ARRAY_FILTER_USE_KEY
                );
            }
			
			foreach($this->orders as $index => $order)
			{
				$this->orders[ltrim($order,'+-')] = ($order[0] === '-') ? 'desc':'asc';
				unset($this->orders[$index]);
			}				
        }
    }

    /**
     * Return if exists url Order parameter
     *
     * @return boolean
     */    
    protected function hasOrder()
    {
        return (isset($this->orders) and count($this->orders));
    }

    /**
     * Return url Orders array
     *
     * @return array
     */
    protected function getOrder($key=null)	
    {
        if ($this->hasOrder()) {
            return isset($this->orders[$key]) ? $this->orders[$key]: $this->orders;
        } else {
            return null;
        }       		
    }    
}