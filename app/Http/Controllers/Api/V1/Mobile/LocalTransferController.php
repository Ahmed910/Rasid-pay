<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\BalanceTypeRequest;
use App\Http\Requests\V1\Mobile\LocalTransferRequest;
use  App\Http\Resources\Mobile\LocalTransferResource;
use App\Models\{CitizenWallet,Transaction,Transfer};


class LocalTransferController extends Controller
{


    public function store(LocalTransferRequest $request)
    {
        // check main_balance is suffienct or not

        $main_balance_for_current_user = CitizenWallet::where('citizen_id',auth()->id())->firstOrFail();

        if(($request->balance_type === 'pay' && ($main_balance_for_current_user->main_balance < $request->amount)) || ($request->balance_type === 'back' && ($main_balance_for_current_user->cash_back < $request->amount)))
        {
            return response()->json(['data'=>null,'message'=>trans('mobile.local_transfers.current_balance_is_not_sufficiant_to_complete_transaction'),'status'=>false],422);
        }

       $local_transfer = Transfer::create($request->only('amount','transfer_fees')+['transfer_type'=>'local','from_user_id'=>auth()->id()]);
       $local_transfer->bank_transfer()->create($request->except('amount','transfer_fees'));

       if($request->balance_type === 'pay')
       {
           $main_balance_for_current_user->decrement('main_balance',$request->amount);

       }else{
            $main_balance_for_current_user->decrement('cash_back',$request->amount);
       }
Transaction::create(['from_user_id'=>auth()->id(),'amount'=>$request->amount,'status'=>'success']);
       return response()->json(['data'=>null,'message'=>trans('mobile.local_transfers.transfer_has_been_done_successfully'),'status'=>true]);

    }

    public function getLocalTransfer($id)
    {
        $transfer = Transfer::with('bank_transfer')->findOrFail($id);

        return
        LocalTransferResource::make($transfer)->additional(['status' => true, 'message' => ""]);
    }








}
