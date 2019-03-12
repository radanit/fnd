<?php

namespace App\Radan\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
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
            'avatar' => $this->avatar,
            // Cast to boolean in Auth\Models\User
            'active' => $this->active,
            'profile_id' => $this->type_id,
            'profile_name' => $this->type,
            'last_login' => $this->last_login,
            
            // Cast to array in Auth\Models\Role
            'roles' => $this->when(true, function() {
                $return = '';
                foreach($this->roles as $role) {
                    $return .= $role->name.',';
                }
                return trim($return,',');
            }),
        ];
    }
}
