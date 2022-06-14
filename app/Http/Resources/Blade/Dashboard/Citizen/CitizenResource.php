<?php

namespace App\Http\Resources\Blade\Dashboard\Citizen;

use Illuminate\Http\Resources\Json\JsonResource;


class CitizenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullname' => $this->user->fullname,
            'identity_number' => $this->user->identity_number,
            'phone' => $this->user->phone,
            'phone_without_cc' => substr($this->user->phone, strlen($this->user->country_code)),
            'enabled_package' => $this->enabledPackage?->package?->name ?? trans('dashboard.citizens.without'),
            'card_end_at' => $this->enabledPackage?->end_at ?? trans('dashboard.citizens.without'),
            'show_route' => route('dashboard.citizen.show', $this->id),
            'edit_route' => route('dashboard.citizen.edit', $this->id),
            'update_route' => route('dashboard.citizen.update_phone', $this->user->id),
            'created_at' => $this->created_at,
            'start_from' => $request->start
        ];
    }
}
