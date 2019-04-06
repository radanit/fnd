<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'first_name' => $this->first_name,        
            'last_name' => $this->last_name,
            'speciality_id' => $this->speciality,
            'speciality_description' => $this->speciality_desc,
        ];
    }
}
