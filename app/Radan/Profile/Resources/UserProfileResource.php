<?php

namespace App\Radan\Profile\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
        'profile' => $this->profile,
        'user' => $this->user,
        'date' => $this->date,
        /*'created_at' => (string) $this->created_at,
        'updated_at' => (string) $this->updated_at,
        'deleted_at' => (string) $this->deleted_at,*/
      ];
    }
}
