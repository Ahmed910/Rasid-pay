<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'token' => $this->when($this->token, $this->token),
            'id' => $this->id,
            'fullname' => $this->fullname,
            'identity_number' => $this->identity_number,
            'country_code' => substr($this->phone, 0, 3),
            'phone' => substr($this->mask_phone ?? $this->phone, 3),
            'image' => $this->image,
            'has_image' => $this->images()->exists(),
            'wallet_number' => (string)$this->citizenWallet?->wallet_number,
            'is_phone_verified' => (bool)$this->phone_verified_at,
            'created_at' => $this->created_at_date,
            'is_notification_enabled'=> $this->when($this->user_type == "citizen",(bool)$this->is_notification_enabled),
            'address' => AddressResource::make($this->whenLoaded('citizen'))
        ];
    }
}
