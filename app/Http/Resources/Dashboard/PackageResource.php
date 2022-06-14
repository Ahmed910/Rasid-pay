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
        foreach ($this->clientPackages as $clientPackage) {
            if ($clientPackage->id == $clientPackage->pivot->package_id) {
                $package_discount[$clientPackage->name] = $clientPackage->pivot->package_discount;
            }
        }

        return [
            "fullname" => $this->fullname,
            "basic_discount" => $package_discount[trans('dashboard.cardpackage.basic')] ?? trans('dashboard.package.without'),
            "golden_discount" =>  $package_discount[trans('dashboard.cardpackage.golden')] ?? trans('dashboard.package.without'),
            "platinum_discount" =>  $package_discount[trans('dashboard.cardpackage.platinum')] ?? trans('dashboard.package.without'),
        ];
    }
}
