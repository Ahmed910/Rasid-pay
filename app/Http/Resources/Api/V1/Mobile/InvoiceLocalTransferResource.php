<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceLocalTransferResource extends JsonResource
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
            'id'              => $this->id,
            'transfer_type'    =>$this->transfer_type,
            'transfer_date'    =>$this->created_at,
          //  'refrence_number' => $this->transaction->transaction_id,
            'amount'           =>$this->amount,
            'transfer_fees'    => $this->transfer_fees,
            'total_amount'     =>(string)($this->amount+$this->transfer_fees) ,
            'beneficiary_name'      => $this->bank_transfer->benficiary->name,
            'transfer_purpose'     => $this->bank_transfer->transferPurpose->name,
        ] ;
    }
}
