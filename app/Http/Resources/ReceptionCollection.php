<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceptionCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {        
        return [
            'id' => $this->id,
            'reception_date' => $this->reception_date,
            'patient' => [
                'national_id' => $this->national_id,
				'first_name' => $this->first_name,
				'last_name' => $this->last_name,
                'fullname' => $this->first_name.' '.$this->last_name,
                'mobile' => $this->mobile,
                'gender' => $this->gender,
                'birth_year' => $this->birth_year,
            ],
            'description' => $this->description,
            'radio_type_name' => $this->radioType->name,
            'status' => $this->whenLoaded('status')->last()->status,
            'status_description' => __('bahar.reception_status.'.$this->whenLoaded('status')->last()->status),
        ];
    }
}
