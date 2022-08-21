<?php

namespace App\Http\Resources\Api\Mobile;

use App\Models\TransferFee;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingVariablesResource extends JsonResource
{

    // local transfers

    public function toArray($request)
    {
        $global_fees = TransferFee::select('amount_from', 'amount_to', 'amount_fee')->get();
        return [
            'local_transfer_fees' => number_format($this->resource, 2, '.', ''),
            'ranges' => FeeSettingResource::collection($global_fees),
            'wallet_transfer' => [
                'min' =>(string) number_format(setting('rasidpay_wallettransfer_minvalue'), 2, '.', ''),
                'max' =>(string) number_format(setting('rasidpay_wallettransfer_maxvalue'), 2, '.', '')
            ],
            'wallet_charge' => [
                'min' =>(string) number_format(setting('rasidpay_walletcharge_minvalue'), 2, '.', ''),
                'max' => (string)number_format(setting('rasidpay_walletcharge_maxvalue'), 2, '.', ''),
            ],
            'local_transfer' => [
                'min' => (string)number_format(setting('rasidpay_localtransfer_minvalue'), 2, '.', ''),
                'max' => (string)number_format(setting('rasidpay_localtransfer_maxvalue'), 2, '.', ''),
            ],
            'global_transfer' => [
                'min' => (string)number_format(setting('rasidpay_inttransfer_minvalue'), 2, '.', ''),
                'max' => (string)number_format(setting('rasidpay_inttransfer_maxvalue'), 2, '.', '')
            ],
        ];
    }
}
