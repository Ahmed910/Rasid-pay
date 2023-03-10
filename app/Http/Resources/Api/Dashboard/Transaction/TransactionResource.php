<?php

namespace App\Http\Resources\Api\Dashboard\Transaction;

use App\Models\Transfer;
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

        $transfer_fee_upon = $this->when(in_array($this->trans_type, ['global_transfer', 'local_transfer']), (string)$this->transactionable?->fee_upon);
        $_amount = ($transfer_fee_upon == Transfer::FROM_USER) ? ($this->amount - $this->fee_amount) : ($this->amount + $this->fee_amount);
        $fee_amount = ($transfer_fee_upon == Transfer::FROM_USER) ? $this->fee_amount : 0;
        $total_amount = ($transfer_fee_upon == Transfer::FROM_USER) ? $this->amount : ($this->amount + $this->fee_amount);

        return [
            'id' => $this->id,
            'number' => $this->trans_number,
            'created_at' => $this->created_at_date_time,
            'citizen' => $this->fromUser?->fullname,
            'vendor' => $this->vendor?->name,
            'vendor_discount' => (float)$this->vendor_discount,
            'type' => $this->trans_type,
            'type_trans' => $this->trans_type ? trans("dashboard.transaction.type_cases.{$this->trans_type}") : "",
            'status' => $this->trans_status ? trans("dashboard.transaction.status_cases.{$this->trans_status}") : "",
            'status_code' => $status_codes[$this->trans_status],
            'amount' => number_format($total_amount, 2, '.', ''),
            'invoice_amount' => $this->when($this->trans_type == 'payment', number_format($this->amount, 2)),
            'cash_back' => $this->fromUser?->citizenWallet?->cash_back ?? 0,
            'enabled_package' => trans('dashboard.package_types.' . $this->fromUser?->citizen?->enabledPackage?->package_type) ?? trans('dashboard.citizens.without'),
            'actions' => $this->when($request->routeIs('transactions.index'), [
                'show' => auth()->user()->hasPermissions('transactions.show'),
            ]),
        ];
    }
}
