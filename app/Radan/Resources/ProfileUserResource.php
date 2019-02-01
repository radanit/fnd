<?php

namespace App\Radan\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileUserResource extends JsonResource
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
            'data' => $this->data,
            'profile' => ProfileResource::collection($this->profile),
        ];
    }
}
