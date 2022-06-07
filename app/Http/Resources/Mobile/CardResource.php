<?php

namespace App\Http\Resources\Mobile;

use App\Http\Resources\Dashboard\SimpleCitizenResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CardResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'owner_name' => $this->owner_name,
            'card_name' => $this->card_name,
            'card_number' => Str::mask($this->card_number, '*','-16','12'),
            'card_type' => $this->card_type,
            'created_at' => $this->created_at,
            'expires_at' => $this->expires_at,
            'amount' => $this->amount,
            'main_balance' => $this->amount,
            'user' => SimpleCitizenResource::make($this->user),
        ];
    }
}
