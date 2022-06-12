<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class GLobalTransferResource extends JsonResource
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
            'id'                       => $this->id,
            'from_user_id'             => $this->from_user_id,
            'beneficiary_id '          => $this->bank_transfer->beneficiary_id,
            'beneficiary'              => $this->bank_transfer->beneficiary->name,
            'beneficiary_country_id'   => $this->bank_transfer->beneficiary->country_id,
            'beneficiary_country'      => $this->bank_transfer->beneficiary->country->name,
            'balance_type'             => $this->bank_transfer->balance_type,
            'amount'                   => $this->amount,
            'amount_transfer'          => $this->amount_transfer,
            'transfer_fees'            => $this->transfer_fees,
            'total_amount'             => (string)($this->amount + $this->transfer_fees),
            'fee_upon'                 => $this->fee_upon,
            'currency_id'              => $this->bank_transfer->currency_id,
            'currency'                 => $this->bank_transfer->currency->name,
            'to_currency_id'           => $this->bank_transfer->to_currency_id,
            'to_currency'              => $this->bank_transfer->toCurrency->name,
            'transfer_type'            => $this->transfer_type,
            'transfer_status'          => $this->transfer_status,
            'transfer_purpose_id'      => $this->bank_transfer->transfer_purpose_id,
            'transfer_purpose'         => $this->bank_transfer->transferPurpose->name,
            'recieve_option_id'        => $this->bank_transfer->recieve_option_id,
            'recieve_option'           => $this->bank_transfer->recieveOption->name,
            'mtcn_number'              => $this->bank_transfer->mtcn_number,
            'exchange_rate'            => $this->bank_transfer->exchange_rate,


        ];
    }
}
