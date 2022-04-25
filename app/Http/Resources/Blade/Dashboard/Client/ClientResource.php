<?php

namespace App\Http\Resources\Blade\Dashboard\Client;

use Illuminate\Http\Resources\Json\JsonResource;


class ClientResource extends JsonResource
{
    public function toArray($request)
    {
        // dd($this->bankAccount->bank->name);
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'client_type' => !$this->client?->client_type ? '' : trans("dashboard.client.client_type.{$this->client?->client_type}"),
            'commercial_number' => $this->client?->commercial_number,
            'tax_number' => $this->client?->tax_number,
            'transactions_done' => $this->client?->transactions_done,
            'bank_name' => $this->bankAccount?->bank?->name,
            'account_status' =>  !$this->bankAccount?->account_status ? '' : trans("dashboard.client.account_statuses.{$this->bankAccount?->account_status}"),
            'show_route' => route('dashboard.client.show', $this->id),
            'edit_route' => route('dashboard.client.edit', $this->id),
            'created_at' => $this->created_at,
            'start_from' => $request->start

        ];
    }
}
