<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [
                'local_transfer_fees' => setting('rasidpay_localtransfer_transferfees')
            ],
            'status' => true,
            'message' =>  '',
        ]);
    }
}
