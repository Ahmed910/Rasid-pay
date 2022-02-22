<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\Departments\DepartmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'gender' => $this->gender,
            'is_active' => (bool)$this->is_active,
            'is_ban' => (bool)$this->is_ban,
            'department' => DepartmentResource::make($this->whenLoaded('department')),
            'added_by_id' => SimpleUserResource::make($this->whenLoaded('addedBy')),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'identity_number' => $this->when(request()->is('*/employees/*'), $this->identity_number),
            'date_of_birth' => $this->when(request()->is('*/employees/*'), $this->date_of_birth),
            'date_of_birth_hijri' => $this->when(request()->is('*/employees/*'), $this->date_of_birth_hijri),
            'ban_reason' => $this->when(request()->is('*/employees/*'), $this->ban_reason),
            'is_ban_always' => $this->when(request()->is('*/employees/*'), $this->is_ban_always),
            'ban_from' => $this->when(request()->is('*/employees/*'), $this->ban_from),
            'ban_to' => $this->when(request()->is('*/employees/*'), $this->ban_to),
            'created_at' => $this->created_at,
        ];
    }
}
