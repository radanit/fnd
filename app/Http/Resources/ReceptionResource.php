<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'reception_date' => $this->reception_date,
            'patient' => [
                'national_id' => $this->national_id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'fullname' => $this->__gender($this->gender).' '.$this->first_name.' '.$this->last_name,
                'mobile' => $this->mobile,
                'gender' => $this->gender,
                'birth_year' => $this->birth_year,
            ],
            'description' => $this->description,
            'graphy_result' => $this->graphy_result,
            'doctor' => new DoctorResource($this->doctor),
            'doctor_id' => $this->doctor_id,
            'radio_type_id' => $this->radioType->id,
            'radio_cat_id' => $this->radioType->radio_cat_id,
            'radio_type_name' => $this->radioType->name,
            'status' => new ReceptionStatusResource($this->whenLoaded('status')->last()),
			'graphy_dicom' => MediaResource::collection($this->getMedia('graphy_dicom')),
			'graphy_jpg' => MediaResource::collection($this->getMedia('graphy_jpg')),
			'results' => ReceptionResultCollection::collection($this->whenLoaded('results')),	
        ];
    }

    private function __gender() 
    {
        return ($this->gender) ? __('patient.female'):__('patient.male');
        
    }
}
