<?php

namespace App\Http\Resources\Api\V1\Dashboard;

use App\Http\Resources\Api\V1\Dashboard\Department\DepartmentResource;
use App\Http\Resources\Api\V1\Dashboard\Group\{GroupResource, PermissionResource};
use App\Http\Resources\Api\V1\Dashboard\RasidJob\RasidJobResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'country_code' => substr($this->phone, 0, 3),
            'phone' => substr($this->phone, 3),
            'whatsapp' => $this->whatsapp,
            'gender' => $this->gender,
            'is_phone_verified' => (bool)$this->is_active,
            'ban_status' => $this->ban_status,
            'ban_from' => $this->ban_from,
            'ban_to' => $this->ban_to,
            'login_id' => $this->login_id,
            'department' => $this->when(in_array($this->user_type, ['admin', 'employee']), DepartmentResource::make($this->department)),
            'is_date_hijri' => (bool)$this->is_date_hijri,
            'is_password_changed' => (bool)$this->is_password_changed,
            'is_login_code' => (bool)$this->is_login_code,
            'addedBy' => SimpleUserResource::make($this->addedBy),
            'groups' => GroupResource::collection($this->whenLoaded('groups')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'user_type' => $this->user_type,
            'client_type' => $this->when(request()->is('*/admins/*'), $this->client_type),
            'identity_number' => $this->when(request()->is('*/admins/*'), $this->identity_number),
            'register_status' => $this->when(request()->is('*/admins/*'), $this->register_status),
            'created_at' => $this->created_at_date,
            'token' => $this->when($this->token, $this->token),
            'has_message_type' => $this->messageTypes()->exists(),
            'job' => $this->when($this->employee?->job, RasidJobResource::make($this->employee?->job)),
            'actions' => $this->when($request->routeIs('admins.index'), [
                'update' => auth()->user()->hasPermissions('admins.update'),
                'show' => auth()->user()->hasPermissions('admins.show')
            ])
        ];
    }
}
