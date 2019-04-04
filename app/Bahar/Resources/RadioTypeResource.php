<?php

namespace App\Bahar\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RadioTypeResource extends JsonResource
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
            'name' => $this->name,        
            'description' => $this->description,
            'role_id' => $this->role_id,
            'role_description' => $this->whenLoaded('role',function() {
                return $this->role->description;
            }),
        ];
    }
}
