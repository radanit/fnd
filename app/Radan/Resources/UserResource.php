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
            'profile_id' => $this->profileUser->profile_id,
            'profile_name' => $this->profileUser->profile->description,
            // Cast to array in Profile\Models\ProfileUser
            'data' => $this->profileUser->data,
            // Cast to array in Auth\Models\Role
            'roles' => $this->roles,
        ];
    }
}
