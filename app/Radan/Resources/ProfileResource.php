<?php

namespace App\Radan\Resources;

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
            // 'profile_users' => ProfileUserResource::collection($this->profileUsers),
            'description' => $this->description,
            'structure' => $this->structure,
        ];
    }
}
