<?php

namespace App\Radan\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PasswordPolicyResource extends JsonResource
{
    /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [            
            'name' => $this->name,            
            'description' => $this->description,
            'min_length' => $this->min_length,
            'max_length' => $this->max_length,
            'upper_case ' => $this->upper_case,
            'lower_case' => $this->lower_case,
            'digits' => $this->digits,
            'special_chars' => $this->special_chars,
            'does_not_contain' => $this->does_not_contain,
        ];
    }
}
