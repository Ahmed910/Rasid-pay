<?php

namespace App\Http\Resources\Api\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleCitizenResource extends JsonResource
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
            'id' => $this->id,
            'fullname' => $this->fullname,
            'identity_number' => $this->identity_number,
            'ban_status' => $this->ban_status,
            'country_code' => substr($this->phone, 0, 4),
            'phone' => substr($this->phone, 4),
            'user_type' => $this->user_type,
            'date_of_birth' => $this->date_of_birth,
            'images' => ImagesResource::collection($this->whenLoaded('images')),
            'created_at' => $this->created_at,
            'bank_account' => BankAccountResource::make($this->whenLoaded('bankAccount')),
        ];
    }
}
