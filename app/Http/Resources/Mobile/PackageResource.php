<?php

namespace App\Http\Resources\Mobile;

use Carbon\Carbon;
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
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->translate('en')->name,
            'description' => $this->description,
            'color' => $this->color,
            'price' => $this->price,
            'discount' => $this->discount,
            'expire_at' => Carbon::now()->addMonths($this->duration)->format('Y/m/d'),
        ];
    }
}
