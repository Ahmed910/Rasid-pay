<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Transfers\WalletTransferRequest;
use App\Http\Resources\Mobile\LocalTransferResource;
use App\Http\Resources\Mobile\WalletTransferResource;
use App\Models\CitizenWallet;
use App\Models\Transfer;
use Illuminate\Http\Request;

class WalletTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WalletTransferRequest $request, Transfer $transfer)
    {
        $wallet = CitizenWallet::with('citizen')->where('citizen_id', auth()->id())->firstOrFail();
        if ($request->citizen_id) {
            // TODO: Check if citizen has wallet if not create one
            $receiver_citizen_wallet = CitizenWallet::with('citizen')->where('citizen_id', $request->citizen_id)->firstOrFail();
        }elseif (!$request->citizen_id && in_array($request->transfer_status,['hold','transfered'])) {
            $phone = $request->transfer_method_value;
        }else{
            return response()->json([
                'status' => false,
                'data' =>
            ]);
        }
        // $reciver = $transfer->get_wallet_receiver($request->wallet_transfer_method, $request->transfer_type_value);

        // calculating and sending amount
        $cur = $request->amount;
        if ($request->amount > $wallet->main_balance + $wallet->cash_back)
            return response()->json(['data' => null, 'message' => trans('mobile.local_transfers.current_balance_is_not_sufficiant_to_complete_transaction'), 'status' => false], 422);
        $cashback_remaining_balance = max(($wallet->cash_back - $request->amount),0);
        // $from_back = $cur > $wallet->cash_back ? $wallet->cash_back : $cur;
        $wallet_data = ["cash_back" => $cashback_remaining_balance];
        if ($cashback_remaining_balance) {
            $wallet_data += ['main_balance' => $wallet->main_balance - ($request->amount - $wallet->cash_back)];
        }
        $wallet->update($wallet_data);
        $cur -= $from_back;
        if ($cur) {
            $from_pay = $cur > $wallet->main_balance ? $wallet->main_balance : $cur;
            $wallet->decrement("main_balance", $from_pay);
            if ($reciver) $reciver->increment("main_balance", $from_pay);
        }

        // create a transfer
        $data = ['transfer_type' => 'wallet', "fee_upon" => null, 'from_user_id' => auth()->id(), "to_user_id" => $reciver ? $reciver->citizen->id : null];
        if ($request->wallet_transfer_method == "phone") $data += ["phone" => $request->transfer_type_value];
        $local_transfer = $transfer->create($request->validated() + $data);
        return response()->json(
            ['data' => WalletTransferResource::make($local_transfer),
                'message' => trans('mobile.local_transfers.transfer_has_been_done_successfully'),
                'status' => true]
        );

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
