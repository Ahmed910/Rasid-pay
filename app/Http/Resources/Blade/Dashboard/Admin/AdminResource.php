<?php

namespace App\Http\Resources\Blade\Dashboard\Admin;

use App\Http\Resources\Blade\Dashboard\Department\DepartmentResource;
use App\Http\Resources\Dashboard\Group\GroupResource;
use App\Http\Resources\Dashboard\Group\PermissionResource;
use App\Http\Resources\Dashboard\SimpleUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Lang;

class AdminResource extends JsonResource
{
    public function toArray($request)
    {
        //ban status
        if($this->ban_status =='active'){
            $ban_status = trans('dashboard.admin.active_cases.active');
        }
        elseif($this->ban_status =='permanent'){
            $ban_status = trans('dashboard.admin.active_cases.ban_permnent');
        }elseif($this->ban_status =='temporary'){
            $ban_status = trans('dashboard.admin.active_cases.ban_temporary');
        }

        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'gender' => $this->gender,
            'is_phone_verified' => (bool)$this->is_active,
            'ban_status' => $ban_status ,
            'ban_from' => $this->ban_from,
            'ban_to' => $this->ban_to,
            'login_id' => $this->login_id,
            'department' => $this->when(in_array($this->user_type,['admin' , 'employee']), DepartmentResource::make($this->department)),
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
            'show_route' => route('dashboard.admin.show', $this->id),
            'edit_route' => route('dashboard.admin.edit', $this->id),
            'created_at' => $this->created_at,


        ];
    }
}
