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
            "fullname" => $this->fullname,
            "basic_discount" => $this->package?->basic_discount,
            "golden_discount" => $this->package?->golden_discount,
            "platinum_discount" => $this->package?->platinum_discount,
            "edit_route" => route("dashboard.package.edit", $this->package?->id),
            'start_from' => $request->start

        ];
    }
}
