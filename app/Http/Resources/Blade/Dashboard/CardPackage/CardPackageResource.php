<?php

namespace App\Http\Resources\Blade\Dashboard\CardPackage;

use Illuminate\Http\Resources\Json\JsonResource;

class CardPackageResource extends JsonResource
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
            "basic_discount" => $this->cardPackage->basic_discount,
            "golden_discount" => $this->cardPackage->golden_discount,
            "platinum_discount" => $this->cardPackage->platinum_discount,
            "edit_route" =>route("dashboard.card_package.edit",$this->id)
        ];
    }
}
