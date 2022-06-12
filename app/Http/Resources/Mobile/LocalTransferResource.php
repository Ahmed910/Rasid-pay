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
            'id'              => $this->id,
           'beneficiary_name'      => $this->bank_transfer->benficiary->name,
            'transfer_type'    =>$this->transfer_type,
            'amount'           =>$this->amount,
            'transfer_fees'    => $this->transfer_fees,
            'total_amount'     =>(string)($this->amount+$this->transfer_fees) ,

        ] ;
    }
}
