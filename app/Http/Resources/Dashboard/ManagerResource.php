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
            "manager_name" =>$this->manager_name ,
            "manager_email" => $this->manager_email,
            "manager_identity_number" => $this->manager_identity_number,
            "manager_nationality" => $this->manager_nationality,
            "manager_address" => $this->manager_address,
            "manager_gender" => $this->manager_gender,
            "manager_marital_status" => $this->manager_marital_status,
            "manager_date_of_birth" => $this->manager_date_of_birth,
            "manager_date_of_birth_hijri" => $this->manager_date_of_birth_hijri,

        ];
    }
}
