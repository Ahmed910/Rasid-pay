<?php

namespace App\Http\Resources\Blade\Dashboard\Package;

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
            "basic_discount" => array_key_exists(trans('dashboard.cardpackage.basic'), $package_discount) ? $package_discount[trans('dashboard.cardpackage.basic')] : 0,
            "golden_discount" => array_key_exists(trans('dashboard.cardpackage.golden'), $package_discount) ? $package_discount[trans('dashboard.cardpackage.golden')] : 0,
            "platinum_discount" => array_key_exists(trans('dashboard.cardpackage.platinum'), $package_discount) ? $package_discount[trans('dashboard.cardpackage.platinum')] : 0,
            "edit_route" => route("dashboard.package.edit", $this->id),
            'start_from' => $request->start
        ];
    }

}
