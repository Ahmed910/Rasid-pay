<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\TransferFee;

class SettingController extends Controller
{
    public function index()
    {
        $global_fees = TransferFee::select('amount_from', 'amount_to', 'amount_fee')->get();
        return response()->json([
            'data' => [
                'local_transfer_fees' => setting('rasidpay_localtransfer_transferfees'),
                'ranges' => $global_fees,
            ],
            'status' => true,
            'message' => '',
        ]);
    }
}
