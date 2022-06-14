<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $status_codes = [
            'success' => 1,
            'fail' => 2,
            'pending' => 3,
            'received' => 4,
            'cancel' => 5,
        ];
        return [
            'id' => $this->id,
            'number' => $this->trans_number,
            'created_at' => $this->created_at,
            'citizen' => $this->citizen?->fullname,
            'type' => $this->trans_type ? trans("dashboard.transaction.type_cases.{$this->trans_type}") : "",
            'status' => $this->trans_status ? trans("dashboard.transaction.status_cases.{$this->trans_status}") : "",
            'status_code' => $status_codes[$this->trans_status],
            'amount' => $this->amount + $this->fee_amount,
            'enabled_package' => $this->citizen?->citizen?->enabledPackage?->package?->name ?? trans('dashboard.citizens.without'),
            'actions' => $this->when($request->routeIs('transactions.index'), [
                'show' => auth()->user()->hasPermissions('transactions.show'),
            ]),
        ];
    }
}
