<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class BeneficiaryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $this->country?->name,
            'recieve_option' => $this->recieveOption?->name,
            'nationality' => $this->nationality?->nationality,
            'date_of_birth' => format_date($this->date_of_birth),
            'benficiar_type' => $this->benficiar_type,
            'iban_number' => $this->iban_number,
            'relation' => $this->transferRelation?->name,
           // 'total_balance' =>(string) (auth()->user()->citizenWallet->main_balance + auth()->user()->citizenWallet->cash_back)
        ];
    }
}
