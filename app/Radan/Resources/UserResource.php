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
            'active' => $this->active,
            'profileUser' => new ProfileUserResource($this->profileUser),
            'roles' => RoleResource::collection($this->roles),
            //'permissions' => new PermissionResource($this->permissions),
        ];
    }
}
