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
            "basic_discount" => (float)$this->basic_discount ?? trans('dashboard.package.without'),
            "golden_discount" => (float)$this->golden_discount ?? trans('dashboard.package.without') ,
            "platinum_discount" => (float)$this->platinum_discount ?? trans('dashboard.package.without') ,
            'actions' => $this->when($request->routeIs('vendor_packages.index'), [
                'show' => auth()->user()->hasPermissions('vendor_packages.show'),
                'create' => auth()->user()->hasPermissions('vendor_packages.store'),
                'update' => auth()->user()->hasPermissions('vendor_packages.update'),
            ])
        ];
    }
}
