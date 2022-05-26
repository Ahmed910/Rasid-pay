<?php

namespace App\Http\Resources\Dashboard\Banks;

use App\Http\Resources\Dashboard\BankResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BankBranchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'type' => trans("dashboard.bank.types.{$this->type}"),
            'code' => $this->code,
            'site' => $this->site,
            'transfer_amount' => (float) number_format((float)$this->transfer_amount, 2),
            'commercial_record' => (float) number_format((float)$this->commercial_record, 2),
            'tax_number' => $this->tax_number,
            'service_customer' => $this->service_customer,
            'is_active' => (bool) $this->is_active,
            'bank' => $this->whenLoaded('bank', BankResource::make($this->bank))
        ];
    }
}
