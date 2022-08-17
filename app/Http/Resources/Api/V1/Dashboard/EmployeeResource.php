<?php

namespace App\Http\Resources\Api\V1\Dashboard;

use App\Http\Resources\Api\V1\Dashboard\AdditionalEmployeeResource;
use App\Http\Resources\Api\V1\Dashboard\Department\DepartmentResource;
use App\Http\Resources\Api\V1\Dashboard\RasidJob\RasidJobResource;
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
