<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\SettingVariablesResource;

class SettingController extends Controller
{
    public function index()
    {
        $local_fee = setting('rasidpay_localtransfer_transferfees') / 100;
        return SettingVariablesResource::make($local_fee)->additional(['status'=>true,'message'=>'']);
    }
}
