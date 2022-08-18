<?php

namespace App\Http\Resources\Api\Mobile;

use App\Models\TransferFee;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingVariablesResource extends JsonResource
{
    public function toArray($request)
    {
        $global_fees = TransferFee::select('amount_from', 'amount_to', 'amount_fee')->get();
        return [
            'local_transfer_fees' => number_format($this->resource, 2, '.', ''),
            'ranges' => FeeSettingResource::collection($global_fees)
        ];
    }
}
