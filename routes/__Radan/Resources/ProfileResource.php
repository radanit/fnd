<?php

namespace App\Radan\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Radan\Resources\PasswordPolicyResource;

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
            'description' => $this->description,
            'structure' => json_encode($this->structure),
            'password_policy' => new PasswordPolicyResource($this->passwordPolicy),
        ];
    }
}
