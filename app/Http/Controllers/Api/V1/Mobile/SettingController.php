<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\SettingVariablesResource;

class SettingController extends Controller
{
    public function index()
    {
        $local_fee = setting('rasidpay_localtransfer_transferfees') / 100;
        return SettingVariablesResource::make($local_fee)->additional(['status'=>true,'message'=>'']);
    }
}
