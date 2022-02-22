<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\Departments\DepartmentResource;
use App\Http\Resources\Dashboard\Group\GroupResource;
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
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'gender' => $this->gender,
            'is_active' => (bool)$this->is_active,
            'is_ban' => (bool)$this->is_ban,
            'is_ban_always' => (bool)$this->is_ban_always,
            'ban_from' => $this->ban_from,
            'ban_to' => $this->ban_to,
            'is_date_hijri' => (bool)$this->is_date_hijri,
            'department' => DepartmentResource::make($this->whenLoaded('department')),
            'added_by_id' => SimpleUserResource::make($this->whenLoaded('addedBy')),
            'groups' => GroupResource::collection($this->whenLoaded('groups')),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'user_type' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->user_type),
            'client_type' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->client_type),
            'ban_reason' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->ban_reason),
            'identity_number' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->identity_number),
            'register_status' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->register_status),
            'rate_avg' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->rate_avg),
            'date_of_birth' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->date_of_birth),
            'date_of_birth_hijri' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->date_of_birth_hijri),
            'created_at' => $this->created_at,
            'token' => $this->when($this->token, $this->token),
        ];
    }
}
