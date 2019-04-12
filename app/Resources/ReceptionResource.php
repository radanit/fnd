<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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
            'patient' => new PatientResource($this->patient),                 
            'radio_type_id' => $this->radioType->id,
            'radio_type_name' => $this->radioType->name,
            'status_description' => __('bahar.reception_status.'.$this->last_status),
            'status' => $this->last_status,
            'status_id' => $this->last_status_id,
        ];
    }
}
