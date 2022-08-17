<?php

namespace App\Http\Resources\Api\V1\Dashboard;

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
            "platinum_discount" => $this->platinum_discount ?? trans('dashboard.package.without') ,
            'actions' => $this->when($request->routeIs('vendor_packages.index'), [
                'show' => auth()->user()->hasPermissions('vendor_packages.show'),
                'create' => auth()->user()->hasPermissions('vendor_packages.store'),
                'update' => auth()->user()->hasPermissions('vendor_packages.update'),
            ])
        ];
    }
}
