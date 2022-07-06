<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Transfers\TransferTypeRequest;
use App\Http\Resources\Api\V1\Mobile\TransferResource;
use App\Models\CitizenWallet;
use App\Models\Transaction;
use App\Models\Transfer;


class TransferController extends Controller
{
    public function index(TransferTypeRequest $request)
    {
        $transfers = Transfer::where('transfer_type','wallet')->when($request->transfer_type, function ($query) use ($request) {
            switch ($request->transfer_type) {
                case 'outgoing_transfers':
                    $query->with('fromUser')->where('from_user_id', auth()->id());
                    break;
                default:
                    $query->with('toUser')->where('to_user_id', auth()->id());
            }
        })->paginate((int)($request->per_page ?? config("globals.per_page")));

        return TransferResource::collection($transfers)->additional(
            [
                'message' => '',
                'status' => true
            ]
        );
    }


    public function cancelTransfer($transfer_id)
    {
        $user_id = auth()->id();

        $transfer = Transfer::where(['from_user_id'=>$user_id,'transfer_status'=>Transfer::HOLD,'transfer_type'=>Transfer::WALLET])->findOrFail($transfer_id);
        $current_user_wallet = CitizenWallet::where('citizen_id',$transfer->from_user_id)->firstOrFail();
        $transfer->update(['transfer_status' => Transfer::CANCELED]);
        $citizen_wallet_data = ["cash_back" => \DB::raw('cash_back + ' . $transfer->cashback_amount), 'main_balance' => \DB::raw('main_balance + ' . $transfer->main_amount)];
        $current_user_wallet->update($citizen_wallet_data);
       // $transfered_user_wallet->decrement('main_balance',$transfer->amount);
        $transfer->transaction()->update([
            'trans_type'=> Transaction::TRANACTION_TYPES[0],
            'trans_status'=> Transaction::CANCELED,
            'amount'=> $transfer->main_amount,
        ]);

        return TransferResource::make($transfer->refresh())->additional([
            'message' => trans('mobile.transfer.transfer_canceled_successfully_and_money_back_to_your_wallet'),
            'status' => true
        ]);

    }

    public function destroy($id)
    {
        $transfer = Transfer::findOrFail($id);
        $transfer->delete();

        return TransferResource::make($transfer)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_delete')
            ]);
    }
}
