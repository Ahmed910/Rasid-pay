<?php

namespace App\Http\Resources\Api\Mobile;

use App\Models\CitizenPackage;
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
        $current_package = auth()->user()->citizen()->with('enabledPackage')->first();
        // desc for development purpose only
        return [
            'name' => $this->resource,
            'name_translation' => trans('mobile.package_types.' . $this->resource),
            'price' => (string)setting('rasidpay_cards_' . $this->resource . '_price') ?? "",
            'description' => setting('rasidpay_cards_' . $this->resource . '_desc') ?? "",
            'color' => (string)setting('rasidpay_cards_' . $this->resource . '_color') ?? "",
            'image' => asset(setting('rasidpay_cards_' . $this->resource . '_bgimg')) ?? "",
            'is_current' => $current_package->enabledPackage->package_type == $this->resource,
            'end_at' => $current_package->enabledPackage->package_type == $this->resource ? $current_package->enabledPackage?->end_at : null,
            'start_at' => $current_package->enabledPackage->package_type == $this->resource ? $current_package->enabledPackage?->start_at : null,
            'has_promo_codes' => $this->resource == CitizenPackage::PLATINUM,
        ];
    }
}
