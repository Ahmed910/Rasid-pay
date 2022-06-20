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
        return [
            "fullname" => $this->name,
            "basic_discount" => $this->basic_discount ?? trans('dashboard.package.without'),
            "golden_discount" => $this->golden_discount ?? trans('dashboard.package.without') ,
            "platinum_discount" => $this->palatinum_discount ?? trans('dashboard.package.without') ,
            "edit_route" => route("dashboard.client_package.edit", $this->id),
            'start_from' => $request->start
        ];
    }

}
