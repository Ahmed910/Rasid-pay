<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class LocalTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'beneficiary_name' => $this->bankTransfer?->benficiary->name,
            'transfer_type'   => $this->transfer_type,
            'transfer_type_trans' => trans('mobile.transaction.transaction_types.' . $this->transfer_type),
            'amount'  => $this->amount,
            'transfer_fee'    => $this->fee_amount,
            'total_amount'    => (string) ($this->amount + $this->fee_amount),
        ] ;
    }
}
