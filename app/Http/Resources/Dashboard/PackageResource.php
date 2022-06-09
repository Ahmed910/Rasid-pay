<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Package\Package;
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
            "basic_discount" => array_key_exists(trans('dashboard.cardpackage.basic'), $package_discount) ? $package_discount[trans('dashboard.cardpackage.basic')] : trans('dashboard.package.without') ,
            "golden_discount" => array_key_exists(trans('dashboard.cardpackage.golden'), $package_discount) ? $package_discount[trans('dashboard.cardpackage.golden')] :trans('dashboard.package.without') ,
            "platinum_discount" => array_key_exists(trans('dashboard.cardpackage.platinum'), $package_discount) ? $package_discount[trans('dashboard.cardpackage.platinum')] : trans('dashboard.package.without') ,
            "edit_route" => route("client_package.store", $this->id),
            'start_from' => $request->start
        ];
    }

}
