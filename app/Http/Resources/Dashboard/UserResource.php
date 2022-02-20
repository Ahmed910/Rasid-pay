<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\Role\RoleResource;
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
            'is_ban' => $this->is_ban,
            'added_by_id' => SimpleUserResource::make($this->whenLoaded('addedBy')),
            'role' => RoleResource::make($this->whenLoaded('role')),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'user_type' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->user_type),
            'client_type' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->client_type),
            'is_admin_active_user' => $this->when(request()->is('*/admins/*') && !request()->is('*/admins/archive'), $this->is_admin_active_user),
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
