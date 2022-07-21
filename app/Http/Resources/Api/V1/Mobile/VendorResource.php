<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $auth_package_type = auth()->user()->citizen?->enabledPackage?->package_type;
        $discount = match ($auth_package_type) {
            'basic' => $this->package?->basic_discount,
            'golden' => $this->package?->golden_discount,
            'platinum' => $this->package?->platinum_discount,
        };
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'logo' => $this->logo,
            'max_discount' => $this->max_discount,
            'current_discount_according_to_auth_card_user' => $discount,
            
        ];
    }
}
