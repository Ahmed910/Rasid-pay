<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'token' => $this->when($this->token, $this->token),
            'id' => $this->id,
            'fullname' => $this->fullname,
            'identity_number' =>  $this->identity_number,
            'phone' => $this->phone,
            'image' => $this->image,
            //  'email' => $this->email,
            //  'whatsapp' => $this->whatsapp,
            'is_phone_verified' => (bool)$this->phone_verified_at,
            // 'ban_status' => $this->ban_status,
            // 'ban_from' => $this->ban_from,
            // 'ban_to' => $this->ban_to,
            'created_at' => $this->created_at,
            'address' => AddressResource::make($this->whenLoaded('citizen'))
        ];
    }
}
