<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\LocalTransferRequest;
use App\Models\CitizenWallet;
use App\Models\Transfer;
use Illuminate\Http\Request;

class LocalTransferController extends Controller
{
    public function store(LocalTransferRequest $request)
    {
        // check main_balance is suffienct or not
        $main_balance_for_current_user = CitizenWallet::where('citizen_id',auth()->id())->select('main_balance')->firstOrFail();
        if($main_balance_for_current_user->main_balance < $request->amount)
        {
            return response()->json(['data'=>'','message'=>trans('mobile.local_transfers.current_balance_is_not_sufficiant_to_complete_transaction'),'status'=>'error'],422);
        }
       $local_transfer = Transfer::create($request->only('amount','transfer_fees')+['transfer_type'=>'local','from_user_id'=>auth()->id]);
       $local_transfer->bank_transfer()->create($request->except('amount','transfer_fees'));
    }
}
