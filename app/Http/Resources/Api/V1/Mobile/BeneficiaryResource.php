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
            'user_id' => $this->user?->fullname,
            'recieve_option' => $this->recieveOption?->name,
            'nationality' => $this->nationality,
            'date_of_birth' => format_date($this->date_of_birth),
            'benficiar_type' => $this->benficiar_type,
            'iban_number' => $this->iban_number,
            'relation' => $this->relation,
        ];
    }
}
