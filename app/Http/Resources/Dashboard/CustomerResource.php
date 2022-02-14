<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            "fullname" => $this->fullname,
            "email" => $this->email,
            "phone" => $this->phone,
            "whatsapp" => $this->whatsapp,
            "identity_number" => $this->identity_number,
            "client_type" => $this->client_type,
            "date_of_birth" => $this->date_of_birth,
            "date_of_birth_hijri" => $this->date_of_birth_hijri,
//            "image"  =>
        ];
    }
}
