<?php

namespace App\Http\Controllers\Api\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Transfers\TransferTypeRequest;
use App\Http\Resources\Api\Mobile\TransferResource;
use App\Models\CitizenWallet;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index(TransferTypeRequest $request)
    {
        $transfers = Transfer::where('from_user_id', auth()->id())
            ->whereIn('transfer_status', [Transfer::PENDING])
            ->where('transfer_type', Transfer::WALLET)
            ->with('fromUser')
            ->latest()
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

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

        $transfer = Transfer::where(['from_user_id' => $user_id, 'transfer_status' => Transfer::PENDING, 'transfer_type' => Transfer::WALLET])->findOrFail($transfer_id);
        $current_user_wallet = CitizenWallet::where('citizen_id', $transfer->from_user_id)->firstOrFail();
        $transfer->update(['transfer_status' => Transfer::CANCELED]);
        $citizen_wallet_data = ["cash_back" => \DB::raw('cash_back + ' . $transfer->cashback_amount), 'main_balance' => \DB::raw('main_balance + ' . $transfer->main_amount)];
        $current_user_wallet->update($citizen_wallet_data);
        // $transfered_user_wallet->decrement('main_balance',$transfer->amount);
        $transfer->transaction()->update([
            'trans_type' => Transaction::TRANACTION_TYPES[0],
            'trans_status' => Transaction::CANCELED,
            'amount' => $transfer->main_amount,
        ]);

        return TransferResource::make($transfer->refresh())->additional([
            'message' => trans('mobile.transfers.cancel_transfer'),
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
                'message' => __('dashboard.general.success_archive')
            ]);
    }


    public function checkTransferredAmount(Request $request)
    {
        // charge transfer
        if ($request->transfer_type == 'wallet_transfer') {
            $rules = [
                "amount" => 'gte:' . setting('rasidpay_wallettransfer_minvalue') . '|lte:' . setting('rasidpay_wallettransfer_maxvalue')
            ];
            $messages = [
                'amount.gte' => trans('validation.wallet_transfer.amount.gte', ['min_amount' => (setting('rasidpay_wallettransfer_minvalue'))]),
                'amount.lte' => trans('validation.wallet_transfer.amount.lte', ['max_amount' => (setting('rasidpay_wallettransfer_maxvalue'))]),
            ];
        }

        // local transfer
        if ($request->transfer_type == 'local_transfer') {
            $rules = [
                "amount" => 'gte:' . setting('rasidpay_localtransfer_minvalue') . '|lte:' . setting('rasidpay_localtransfer_maxvalue')
            ];
            $messages = [
                'amount.gte' => trans('validation.local_transfers.amount.gte', ['min_amount' => (setting('rasidpay_localtransfer_minvalue'))]),
                'amount.lte' => trans('validation.local_transfers.amount.lte', ['max_amount' => (setting('rasidpay_localtransfer_maxvalue'))]),
            ];
        }
        // global transfer
        if ($request->transfer_type == 'global_transfer') {
            $rules = [
                "amount" => 'gte:' . setting('rasidpay_inttransfer_minvalue') . '|lte:' . setting('rasidpay_inttransfer_maxvalue')
            ];
            $messages = [
                'amount.gte' => trans('validation.global_transfers.amount.gte', ['min_amount' => (setting('rasidpay_inttransfer_minvalue'))]),
                'amount.lte' => trans('validation.global_transfers.amount.lte', ['max_amount' => (setting('rasidpay_inttransfer_maxvalue'))]),
            ];
        }
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => false
            ], 422);
        }
        if ($request->amount > auth()->user()->citizenWallet->main_balance) {
            return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficient_to_complete_transaction'), 'status' => false], 422);
        }
        return response()->json([
            'data' => null,
            'message' => "",
            'status' => true
        ], 200);
    }
}
