<?php

namespace App\Http\Resources\Blade\Dashboard\Bank;

use Illuminate\Http\Resources\Json\JsonResource;

class BankBranchResource extends JsonResource
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
            'bank_name' => $this->bank?->name,
            'name' => $this->name,
            'type' => trans("dashboard.bank.types.{$this->type}"),
            'type_name' => $this->type,
            'code' => $this->code,
            'site' => $this->site,
            'transfer_amount' => (float)number_format((float)$this->transfer_amount, 2),
            'commercial_record' => $this->commercial_record,
            'tax_number' => $this->tax_number,
            'service_customer' => $this->service_customer,
            'is_active' => trans('dashboard.department.active_cases.' . $this->is_active),
            'show_route' => route('dashboard.bank.show', $this->bank?->id),
            'edit_route' => route('dashboard.bank.edit', $this->bank?->id),
            'start_from' => $request->start,
            'transactions_count' => $this->bank?->transactions_count,
            "active_case" => $this->is_active
//            'bank' => $this->whenLoaded('bank', BankResource::make($this->bank)),
        ];
    }
}
