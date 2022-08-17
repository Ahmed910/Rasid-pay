<?php

namespace App\Http\Resources\Api\V1\Dashboard;
use Illuminate\Http\Resources\Json\JsonResource;

class CitizenPackageResource extends JsonResource
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
            'id' => $this->id,
            'name' => trans('dashboard.package_types.'. $this->package_type),
            'package_price' => setting('rasidpay_cards_' . $this->package_type . '_price') ?? "",
            'start_at' => $this->start_at_dashboard,
            'end_at' => $this->end_at_dashboard,
        ];
    }
}
