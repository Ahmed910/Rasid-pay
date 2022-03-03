<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
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
            "user" => SimpleUserResource::make($this->whenLoaded("user")),
            "bank" => SimpleUserResource::make($this->whenLoaded("bank")),
            "id" => $this->id,
            "account_name" => $this->account_name,
            "iban_number" => $this->iban_number,
            "contract_type" => $this->contract_type,


        ];
    }
}
