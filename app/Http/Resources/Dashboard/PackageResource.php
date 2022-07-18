<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'client_id' => $this->vendor?->id,
            "fullname" => $this->vendor?->name,
            "basic_discount" => $this->basic_discount ?? trans('dashboard.package.without'),
            "golden_discount" => $this->golden_discount ?? trans('dashboard.package.without') ,
            "platinum_discount" => $this->palatinum_discount ?? trans('dashboard.package.without') ,
        ];
    }
}
