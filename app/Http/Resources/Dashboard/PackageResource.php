<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $package_discount = [];
        $default_package_discount = [];
        foreach ($this->clientPackages as $clientPackage) {
            if ($clientPackage->id == $clientPackage->pivot->package_id) {
                $package_discount[$clientPackage->name] = $clientPackage->pivot->package_discount;
                $default_package_discount[$clientPackage->name] = $clientPackage->discount;
            }
        }
        return [
            "client" => SimpleUserResource::make($this),
            "basic_discount" => $package_discount[trans('dashboard.cardpackage.basic')]?:$default_package_discount[trans('dashboard.cardpackage.basic')],
            "golden_discount" => $package_discount[trans('dashboard.cardpackage.golden')]?:$default_package_discount[trans('dashboard.cardpackage.golden')],
            "platinum_discount" => $package_discount[trans('dashboard.cardpackage.platinum')]?:$default_package_discount[trans('dashboard.cardpackage.platinum')],
        ];
    }
}
