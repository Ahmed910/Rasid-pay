<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\AdditionalEmployeeResource;
use App\Http\Resources\Dashboard\Department\DepartmentResource;
use App\Http\Resources\Dashboard\RasidJob\RasidJobResource;
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
            'user' => UserResource::make($this->whenLoaded('user')),
            'contract_type' => $this->contract_type,
            'salary' => $this->salary,
            'qr_path' => $this->qr_path,
            'qr_code' => $this->qr_code,
            'department' => DepartmentResource::make($this->whenLoaded('department')),
            'job' => RasidJobResource::make($this->whenLoaded('job')),
        ];
    }
}
