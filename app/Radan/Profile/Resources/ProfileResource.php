<?php

namespace App\Radan\Profile\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
        'id' => $this->id,
        'name' => $this->name,
        'user_profile' => $this->userProfile,
        'description' => $this->description,
        'structure' => $this->structure,
        /*'created_at' => (string) $this->created_at,
        'updated_at' => (string) $this->updated_at, */    
      ];
    }
}
