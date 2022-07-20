<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $currentPackageDiscount = auth()->user()->citizen?->enabledPackage?->package_type;
        $discounts = [
            [
                'type' => 'basic',
                'discount' => number_format($this->package?->basic_discount),
                'is_current' => $currentPackageDiscount == 'basic',
                'name' => trans('mobile.package_types.basic'),
                'image' => asset(setting('rasidpay_cards_basic_bgimg')) ?? "",
            ],
            [
                'type' => 'golden',
                'discount' => number_format($this->package?->golden_discount),
                'is_current' => $currentPackageDiscount == 'golden',
                'name' => trans('mobile.package_types.golden'),
                'image' => asset(setting('rasidpay_cards_golden_bgimg')) ?? "",
            ],
            [
                'type' => 'platinum',
                'discount' => number_format($this->package?->platinum_discount),
                'is_current' => $currentPackageDiscount == 'platinum',
                'name' => trans('mobile.package_types.platinum'),
                'image' => asset(setting('rasidpay_cards_platinum_bgimg')) ?? "",
            ],
        ];
        return [
            'vendor' => VendorResource::make($this),
            'branches' => VendorBranchResource::collection($this->branches),
            'packages' => $discounts
        ];
    }
}
