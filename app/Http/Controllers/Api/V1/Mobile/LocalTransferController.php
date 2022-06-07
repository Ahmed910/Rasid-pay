<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\LocalTransferRequest;
use App\Models\Transfer;
use Illuminate\Http\Request;

class LocalTransferController extends Controller
{
    public function store(LocalTransferRequest $request)
    {
        // check main_balance is suffienct or not
       $local_transfer = Transfer::create($request->only('amount','transfer_fees')+['transfer_type'=>'local']);
       $local_transfer->bank_transfer()->create($request->except('amount','transfer_fees'));
    }
}
