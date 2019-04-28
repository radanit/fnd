<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReceptionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'reception_date' => $this->reception_date,
            'patient' => [
                'national_id' => $this->national_id,                
                'fullname' => $this->first_name.' '.$this->last_name,
                'mobile' => $this->mobile,
                'gender' => $this->gender,
                'birth_year' => $this->birth_year,
            ],            
            'radio_type_name' => $this->radioType->name,
            'status' => __('bahar.reception_status.'.$this->whenLoaded('status')->last()->status),
        ];
    }
}
