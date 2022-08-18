<?php

namespace App\Http\Resources\Api\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class FeeSettingResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'amount_from' => number_format($this->amount_from, 2, '.', ''),
            'amount_to' => number_format($this->amount_to, 2, '.', ''),
            'amount_fee' => number_format($this->amount_fee, 2, '.', ''),
        ];
    }
}
