<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ManagerResource extends JsonResource
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
            "id"=>$this->id ,
            "name" =>$this->name ,
            "email" => $this->email,
            "identity_number" => $this->identity_number,
            "nationality" => $this->nationality,
            "address" => $this->address,
            "gender" => $this->gender,
            "marital_status" => $this->marital_status,
            "date_of_birth" => $this->date_of_birth,
            "date_of_birth_hijri" => $this->date_of_birth_hijri,

        ];
    }
}
