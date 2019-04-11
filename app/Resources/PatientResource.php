<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'national_id' => $this->username,
            'first_name' => $this->first_name,        
            'last_name' => $this->last_name,
            'fullname' => $this->fullname,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'birth_year' => $this->birth_year,
            'avatar' => $this->avatar,
        ];
    }
}
