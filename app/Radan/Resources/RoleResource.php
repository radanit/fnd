<?php

namespace App\Radan\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'displayname' => $this->display_name,
            'description' => $this->description,
            'permissions' => PermissionResource::collection($this->permissions),            
        ];
    }
}
