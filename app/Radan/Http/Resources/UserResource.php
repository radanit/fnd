<?php

namespace App\Radan\Http\Resources;

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
            'fullname' => $this->whenLoaded('profile' , function () {
                return $this->fullname;
            }),
            // Cast to boolean in Auth\Models\User
            'active' => $this->active,
            'profile_id' => $this->whenLoaded('profile' , function () {
                return $this->type_id;
            }),
            'profile_name' => $this->whenLoaded('profile' , function () {
                return $this->type;
            }),                    
            'profile_description' => $this->whenLoaded('profile' , function () {
                return $this->type_description;
            }),
            // Cast to array in Profile\Models\ProfileUser
            'profile_data' => $this->whenLoaded('profile' , function () {
                return $this->profile->data;
            }),
            // Cast to array in Auth\Models\Role
            'roles' => $this->roles,
        ];
    }
}
