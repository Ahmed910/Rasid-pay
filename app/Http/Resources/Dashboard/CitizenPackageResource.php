<?php

namespace App\Http\Resources\Dashboard;
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
            'card_type' => $this->card_type,
            'name' => trans('dashboard.citizens.card_type.'.$this->card_type),
            'card_price' => $this->card_price,
            'upgrade_price' => $this->upgrade_price,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
        ];
    }
}
