<?php

namespace App\Http\Resources\Api\V1\Mobile;

use App\Models\Transfer;
use Illuminate\Http\Resources\Json\JsonResource;

class LocalTransferResource extends JsonResource
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
            'beneficiary_name' => $this->bankTransfer?->benficiary->name,
            'transfer_type' => $this->transfer_type,
            'transfer_type_trans' => trans('mobile.transaction.transaction_types.' . $this->transfer_type),
            'amount' =>(string) $this->amount,
            'transfer_fee' => (string)$this->transfer_fee_amount,
            'transfer_fee_percentage' => (string)$this->transfer_fees,
            'total_amount' => $this->fee_upon == Transfer::FROM_USER ? (string)($this->amount + $this->transfer_fee_amount) : (string)($this->amount - $this->transfer_fee_amount),
        ];
    }
}
