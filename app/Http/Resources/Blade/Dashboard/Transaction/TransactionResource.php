<?php

namespace App\Http\Resources\Blade\Dashboard\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'trans_number' => $this->trans_number,
            'created_at' => $this->created_at,
            'user_from' => $this->fromUser?->fullname,
            'trans_type' => $this->trans_type ? trans("dashboard.transaction.type_cases.{$this->trans_type}") : "",
            'trans_status' => $this->trans_status ? trans("dashboard.transaction.status_cases.{$this->trans_status}") : "",
            'enabled_package' => $this->fromUser?->citizen?->enabledPackage?->package?->name ?? trans('dashboard.citizens.without'),
            'start_from' => $request->start,
            'show_route' => route('dashboard.transaction.show', $this->id),
        ];
    }
}
