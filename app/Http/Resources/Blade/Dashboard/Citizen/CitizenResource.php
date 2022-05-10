<?php

namespace App\Http\Resources\Blade\Dashboard\Citizen;

use Illuminate\Http\Resources\Json\JsonResource;


class CitizenResource extends JsonResource
{
    public function toArray($request)
    {
        if(isset($this->cards->id))dd($this->cards);
        return [
            'id' => $this->id,
            'fullname' => $this->user->fullname,
            'identity_number' =>$this->user->identity_number,
            'phone' => $this->user->phone,
            'enabled_card' => $this->enabledCard?->cardPackage?->name,
            'card_end_at' => $this->enabledCard?->end_at,
            'bank_name' => $this->bankAccount?->bank?->name,
            'account_status' =>  !$this->bankAccount?->account_status ? '' : trans("dashboard.citizen.account_statuses.{$this->bankAccount?->account_status}"),
            'show_route' => route('dashboard.citizen.show', $this->id),
            'edit_route' => route('dashboard.citizen.edit', $this->id),
            'update_route' => route('dashboard.citizen.update', $this->id),
            'created_at' => $this->created_at,
            'start_from' => $request->start
        ];
    }
}
