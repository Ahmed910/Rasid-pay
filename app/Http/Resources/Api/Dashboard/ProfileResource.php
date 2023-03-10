<?php

namespace App\Http\Resources\Api\Dashboard;

use App\Http\Resources\Api\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Dashboard\Group\PermissionResource;

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
            'country_code' => substr($this->phone, 0, 3),
            'phone' => substr($this->phone, 3),
            'whatsapp' => $this->whatsapp,
            'identity_number' => $this->identity_number,
            'login_id' => $this->login_id,
            'login_code_required' => (bool)$this->is_login_code,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'date_of_birth_hijri' => $this->date_of_birth_hijri,
            'images' => ImagesResource::collection($this->images),
            'permissions' => $this->user_type == 'superadmin' ? ['*'] : PermissionResource::collection($this->userPermissions()),
            'is_date_hijri' => (bool) $this->is_date_hijri,
            'user_type' => $this->user_type,
            'department' => $this->department?->name,
            'rasid_job' => $this->rasidJob?->name,
        ];
    }
}
