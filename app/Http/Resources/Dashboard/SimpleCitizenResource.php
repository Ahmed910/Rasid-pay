<?php

namespace App\Http\Resources\Dashboard;

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
            "phone" => substr($this->phone, strlen($this->country_code)),
            "country_code" => $this->country_code,
            'user_type' => $this->user_type,
            'date_of_birth' => $this->date_of_birth,
            'images' => ImagesResource::collection($this->whenLoaded('images')),
            'created_at' => $this->created_at,
            'bank_account' => BankAccountResource::make($this->whenLoaded('bankAccount')),
        ];
    }
}
