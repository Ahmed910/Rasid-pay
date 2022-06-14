<?php

namespace App\Http\Resources\Blade\Dashboard\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->trans_number,
            'created_at' => $this->created_at,
            'user_from' => $this->citizen?->fullname,
            'user_identity' => $this->citizen?->identity_number,
            'user_to' => $this->client?->fullname,
            'amount' => (string)$this->amount,
            'total_amount' => (string)$this->amount + (string)$this->fee_amount,
            'cash_back' => (string)$this->cash_back,
            'type' => $this->trans_type ? trans("dashboard.transaction.type_cases.{$this->trans_type}") : "",
            'status' => $this->trans_status ? trans("dashboard.transaction.status_cases.{$this->trans_status}") : "",
            'enabled_package' => $this->citizen?->citizen?->enabledPackage?->package?->name ?? trans('dashboard.citizens.without'),
            'start_from' => $request->start
        ];
    }
}
