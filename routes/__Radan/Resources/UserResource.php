<?php

namespace App\Radan\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            // Accessor attribute define if Profile\Traits\ProfileUserTrait
            'fullname' => $this->fullname, 
            // Cast to boolean in Auth\Models\User
            'active' => $this->active,
            'profile_id' => $this->type_id,
            'profile_name' => $this->type,
            'profile_description' => $this->type_description,
            // Cast to array in Profile\Models\ProfileUser
            'data' => $this->profile->data,
            // Cast to array in Auth\Models\Role
            'roles' => $this->roles,
        ];
    }
}
