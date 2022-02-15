<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'identity_number' => $this->identity_number,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'date_of_birth_hijri' => $this->date_of_birth_hijri,
            'images' => ImagesResource::collection($this->images),
        ];
    }
}
