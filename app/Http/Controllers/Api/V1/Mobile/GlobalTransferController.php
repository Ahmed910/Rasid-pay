<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\GLobalTransferRequest;
use App\Http\Resources\Mobile\GLobalTransferResource;
use App\Models\CitizenWallet;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Http\Request;


class GlobalTransferController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\V1\Mobile\GLobalTransferRequest
     * @return App\Http\Resources\Mobile\GLobalTransferResource
     */
    public function store(GLobalTransferRequest $request, Transfer $transfer)
    {

        //check pin wallet


        // check main_balance is suffienct or not
        $main_balance = CitizenWallet::where('citizen_id',auth('sanctum')->user()->id)->firstOrFail();
        if(($request->balance_type === 'pay' && ($main_balance->main_balance < $request->amount)) || ($request->balance_type === 'back' && ($main_balance->cash_back < $request->amount)))
        {
            return response()->json(['data'=>null,'message'=>trans('mobile.global_transfers.current_balance_is_not_sufficiant_to_complete_transaction'),'status'=>false],422);
        }

        //create transfer
        $transfer->fill($request->only(['amount', 'amount_transfer', 'transfer_fees', 'fee_upon']) + ['from_user_id'=>auth()->id(),'transfer_type'=>'global','transfer_status' =>'pending'])->save();
        $bank_transfer = $transfer->bank_transfer()->create($request->only(['currency_id', 'to_currency_id', 'beneficiary_id', 'transfer_purpose_id', 'balance_type']) + ['transfer_id'=>$transfer->id]);
        $bank_transfer->update(['recieve_option_id'=> $bank_transfer->beneficiary->recieve_option_id ]);

        //check if request is pay or back and decrement balance from wallet
        $request->balance_type === 'pay' ? $main_balance->decrement('main_balance',$request->amount) : $main_balance->decrement('cash_back',$request->amount);

        //add transfer in  transaction
       Transaction::create(['from_user_id'=>auth('sanctum')->id(),'amount'=>$request->amount,'trans_type'=>'transfer','transfer_id' => $transfer->id ,'fee_amount'=>$transfer->transfer_fees ]);

       return GLobalTransferResource::make($transfer)
            ->additional([
                'status'  => true,
                'message' => trans("mobile.global_transfers.transfer_has_been_done_successfully")
            ]);
    }
}
