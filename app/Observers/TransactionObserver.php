<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Str;


class TransactionObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $wallet_transfer_method = [
            'phone'  => $transaction->transactionable?->wallet_transfer_method =='phone'  ? ($transaction->toUser?->phone ?? $transaction->transactionable->phone) :"" ,
            'identity_number'=> $transaction->transactionable?->wallet_transfer_method =='identity_number'  ? $transaction->toUser->identity_number :"",
            'wallet_number'  => $transaction->transactionable?->wallet_transfer_method =='wallet_number'  ? $transaction->toUser->citizenWallet?->wallet_number :"" ,
        ];

        $transaction_details =
        [
            'payment'          => $transaction->trans_type == "payment"  ? trans("mobile.transaction.transaction_details.payment_status", [ 'amount' => $transaction->amount, 'refund_amount' => $transaction->amount ]) : "",
            'wallet_transfer'  => $transaction->trans_type == "wallet_transfer"
                                    ? trans("mobile.transaction.transaction_details.wallet_transfer_status",[ 'amount' => $transaction->amount,'to_user_identity_or_mobile_or_wallet_number' => @$wallet_transfer_method[$transaction->transactionable?->wallet_transfer_method]])
                                    : "",
            'local_transfer'   => $transaction->trans_type == "local_transfer"  ? trans("mobile.transaction.transaction_details.local_transfer_status", [ 'amount' => $transaction->amount, 'beneficiary' => $transaction->transactionable?->beneficiary->name, 'iban' => $transaction->transactionable?->beneficiary->iban_number ]): "" ,
            'global_transfer'  => $transaction->trans_type == "global_transfer"  ? trans("mobile.transaction.transaction_details.global_transfer_status", [ 'amount' => $transaction->amount, 'currency' =>$transaction->transactionable?->bankTransfer?->toCurrency?->currency_code,'beneficiary' => $transaction->transactionable?->beneficiary?->name, 'country' =>$transaction->transactionable?->beneficiary?->country?->name , 'recieve_option'=>$transaction->transactionable?->bankTransfer?->recieveOption?->name ,'mtcn' =>$transaction->transactionable?->bankTransfer?->mtcn_number ]) : "",
            'charge'           => $transaction->trans_type == "charge"  ? trans("mobile.transaction.transaction_details.charge_status", [ 'amount' => $transaction->amount ,'method' => trans('mobile.transaction.charge_types.'.$transaction->transactionable?->charge_type,[ 'card_number' => Str::mask($transaction->card_number, '*', 0,-4) ]) ]) : "",
            'money_request'    => $transaction->trans_type == "money_request" ? trans("mobile.transaction.transaction_details.money_request_status", [ 'amount' => $transaction->amount, 'to_user_identity_or_mobile_or_wallet_number' =>  $wallet_transfer_method[$transaction->transactionable?->wallet_transfer_method] ]):"" ,
            'promote_package'  => $transaction->trans_type == "promote_package" ? trans("mobile.transaction.transaction_details.promote_package_status", [ 'amount' => $transaction->amount,'package_name' => $transaction->fromUser->citizen->enabledPackage->package_type, 'expired_date' => $transaction->fromUser->citizen->enabledPackage->end_at ]):"" ,

        ];

        $notify_data = [
            'title' => trans('mobile.notifications.' . $transaction->trans_type . '.title'),
            'body' => $transaction_details[$transaction->trans_type],
        ];

        auth()->user()->notify(new GeneralNotification($notify_data, ['database']));
        if ($transaction->to_user_id && $transaction->trans_type == 'wallet_transfer') {
            $data = [
                'title' => trans('mobile.notifications.wallet_transfer_to.title'),
                'body' => trans('mobile.notifications.wallet_transfer_to.body', ['amount' => $transaction->amount, 'from_user' => auth()->user()->fullname]),
            ];

            $transaction->toUser->notify(new GeneralNotification($data));
        }
    }
}
