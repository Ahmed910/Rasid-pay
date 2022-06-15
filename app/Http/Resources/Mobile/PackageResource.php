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
        $current_package = auth()->user()->citizen()->with('enabledPackage.package')->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => lcfirst($this->translate('en')->name . '_card'),
            'description' => $this->description,
            'color' => $this->color,
            'price' => $this->price,
            'discount' => $this->discount,
            'duration_type' => 'month',
            'duration' => $this->duration,
            'is_default' => (bool)$this->is_default,
            'is_current' => $current_package->enabledPackage->package_id == $this->id,
            'start_at' => $current_package->enabledPackage->package_id == $this->id ? $current_package->enabledPackage?->start_at : null,
            'end_at' => $current_package->enabledPackage->package_id == $this->id ? $current_package->enabledPackage?->end_at : null,
        ];
    }
}
