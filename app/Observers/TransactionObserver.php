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
     * @param \App\Models\User $user
     * @return void
     */
    public function created(Transaction $transaction)
    {

        $wallet_transfer_method = [
            'phone' => $transaction->transactionable?->wallet_transfer_method == 'phone' ? ($transaction->toUser?->phone ?? $transaction->transactionable->phone) : "",
            'identity_number' => $transaction->transactionable?->wallet_transfer_method == 'identity_number' ? $transaction->toUser->identity_number : "",
            'wallet_number' => $transaction->transactionable?->wallet_transfer_method == 'wallet_number' ? $transaction->toUser->citizenWallet?->wallet_number : "",
        ];
        $transaction->trans_type == 'charge' ? $card_number = substr($transaction->card_number,-4) : "";
        $transaction_notifications =
            [
                'payment' => $transaction->trans_type == "payment" ? trans("mobile.transaction.transaction_notifications.payment_status", ['amount' => number_format($transaction->amount, 2, '.', '')]) : "",
                'wallet_transfer' => $transaction->trans_type == "wallet_transfer"
                    ?  trans(
                        "mobile.transaction.transaction_notifications.wallet_transfer_status",
                        [
                            'amount' => number_format($transaction->amount, 2, '.', ''),
                            'to_user_identity_or_mobile_or_wallet_number' => @$wallet_transfer_method[$transaction->transactionable?->wallet_transfer_method],
                            'transfer_type_trans' => trans('mobile.transfers.wallet_transfer_methods.' . $transaction->transactionable?->wallet_transfer_method)
                        ]
                    ) : "",
                'local_transfer' => $transaction->trans_type == "local_transfer" ? trans(
                    "mobile.transaction.transaction_notifications.local_transfer_status",
                    [
                        'amount' => number_format($transaction->amount, 2, '.', ''),
                        'beneficiary' => $transaction->transactionable?->beneficiary->name,
                        'iban' => $transaction->transactionable?->beneficiary->iban_number
                    ]
                ) : "",
                'global_transfer' => $transaction->trans_type == "global_transfer" ? trans("mobile.transaction.transaction_notifications.global_transfer_status", [
                    'amount' => number_format($transaction->amount, 2, '.', ''),
                    'currency' => $transaction->transactionable?->bankTransfer?->toCurrency?->currency_code,
                    'beneficiary' => $transaction->transactionable?->beneficiary?->name,
                    'country' => $transaction->transactionable?->beneficiary?->country?->name,
                    'recieve_option' => $transaction->transactionable?->bankTransfer?->recieveOption?->name,
                    'mtcn' => $transaction->transactionable?->bankTransfer?->mtcn_number
                ]) : "",
                'charge' => $transaction->trans_type == "charge" ? trans(
                    "mobile.transaction.transaction_notifications.charge_status",
                    [
                        'amount' => number_format($transaction->amount, 2, '.', ''),
                        'method' => trans(
                            'mobile.transaction.charge_types.' . $transaction->transactionable?->charge_type,
                            ['card_number' => $card_number]
                        )
                    ]
                ) : "",
                'money_request' => $transaction->trans_type == "money_request" ? trans(
                    "mobile.transaction.transaction_notifications.money_request_status",
                    [
                        'amount' => number_format($transaction->amount, 2, '.', ''),
                        'to_user_identity_or_mobile_or_wallet_number' => $wallet_transfer_method[$transaction->transactionable?->wallet_transfer_method]
                    ]
                ) : "",
                'promote_package' => $transaction->trans_type == "promote_package" ? trans(
                    "mobile.transaction.transaction_notifications.promote_package_status",
                    [
                        'amount' => number_format($transaction->amount, 2, '.', ''),
                        'package_name' => trans('mobile.package_types.'.$transaction->fromUser->citizen->enabledPackage->package_type),
                        'expired_date' => $transaction->fromUser->citizen->enabledPackage->end_at
                    ]
                ) : "",

            ];

        $notify_data = [
            'title' => trans('mobile.notifications.' . $transaction->trans_type . '.title'),
            'body' => $transaction_notifications[$transaction->trans_type],
        ];

        (auth()->check() && auth()->user()->is_notification_enabled) ? auth()->user()->notify(new GeneralNotification($notify_data, ['database'])) : "";

        if ($transaction->transactionable_type == 'App\Models\CitizenPackage' && request()->has('promo_code') && $transaction->trans_type == 'promote_package') {
            $cash_back = getPercentOfNumber(number_format($transaction->amount, 2, '.', ''), $transaction->transactionable?->promo_discount);
            $data = [
                'title' => trans('mobile.notifications.cash_back.title'),
                'body' => trans('mobile.notifications.cash_back.body', ['from_user' => auth()->user()->fullname]),
            ];

            $transaction->transactionable?->citizen?->is_notification_enabled ? $transaction->transactionable?->citizen->notify(new GeneralNotification($data)) : "";
        }

        if ($transaction->trans_type == 'wallet_transfer') {
            $method =  $transaction->transactionable?->wallet_transfer_method == 'identity_number' ? 'identity_number' :'phone';
            $data = [
                'title' => trans('mobile.notifications.reciever_wallet_transfer.title'),
                'body'  => trans("mobile.notifications.reciever_wallet_transfer.body",[
                                   'amount' => number_format($transaction->amount, 2, '.', ''),
                                   'reciever_transfer_type' => trans('mobile.notifications.reciever_wallet_transfer.reciever_transfer_type.'.$method),
                                   'from_user_identity_or_mobile' =>auth()->user()->$method,
             ]),
            ];

            $transaction->transactionable?->toUser?->is_notification_enabled ? $transaction->transactionable?->toUser->notify(new GeneralNotification($data)) : "";
        }

    }

    public function updated(Transaction $transaction)
    {
        $notify_data = [
            'title' => trans('mobile.notifications.cancel_transfer.title'),
            'body' => trans(
                'mobile.notifications.cancel_transfer.body',
                ['transfer_method_value' => $transaction->transactionable?->wallet_transfer_method == 'phone'
                    ? auth()->user()?->phone : auth()->user()?->identity_number]
            ),
        ];

        (auth()->check() && auth()->user()->is_notification_enabled) ? auth()->user()->notify(new GeneralNotification($notify_data, ['database'])) : '';
    }
}
