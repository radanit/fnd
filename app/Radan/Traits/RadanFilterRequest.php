<?php

namespace App\Radan\Traits;

/**
 * This file is part of Radan, 
 *
 * @license MIT
 * @package Radan/Traits
 */

use Input;
trait RadanRequestFilter
{
    /**
     * Filter http request by passing array casting role
     * 
     * @param array converting array rule pair
     * @return void
     */
    protected function filter($data) {
        // Cast user data
        $newData = $this->cast($data);

        // Change Request parameters by casting data
        Input::merge(Input::all() , $newData);
    }

    protected function cast($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {

            }
        }

        return $data;
    }


}
