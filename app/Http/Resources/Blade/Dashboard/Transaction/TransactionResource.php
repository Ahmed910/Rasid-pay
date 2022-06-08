<?php

namespace App\Http\Resources\Blade\Dashboard\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'created_at' => $this->created_at,
            'user_from' => $this->citizen?->fullname,
            'user_identity' => $this->user_identity,
            'user_to' => $this->client?->fullname,
            'amount' => (string)$this->amount,
            'total_amount' => (string)$this->total_amount,
            'gift_balance' => (string)$this->gift_balance,
            'type' => $this->type ? trans("dashboard.transaction.type_cases.{$this->type}") : "",
            'status' => $this->status ? trans("dashboard.transaction.status_cases.{$this->status}") : "",
            'enabled_package' => $this->citizen?->citizen?->enabledPackage?->package?->name ?? trans('dashboard.citizens.without'),
            'discount_percent' => $this->card->name . ' / ' . $this->discount_percent . '%',
            'start_from' => $request->start
        ];
    }
}
