<?php

namespace App\Http\Resources\Api\Mobile\Transactions;

use App\Http\Resources\Api\Mobile\{Beneficiary\BeneficiaryResource, UserResource};
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TransactionResource extends JsonResource
{

    public function toArray($request)
    {
        $wallet_transfer_method = [
            'phone' => $this->transactionable?->wallet_transfer_method == 'phone' ? (string)($this->toUser?->phone ?? $this->transactionable->phone) : "",
            'identity_number' => $this->transactionable?->wallet_transfer_method == 'identity_number' ? (string)$this->toUser?->identity_number : "",
            'wallet_number' => $this->transactionable?->wallet_transfer_method == 'wallet_number' ? (string)$this->toUser?->citizenWallet?->wallet_number : "",
        ];

        $to_amount = number_format(($this->amount * $this->transactionable?->bankTransfer?->exchange_rate), 2, '.', '');
        $last_card_number = substr($this->card_number, -4);

        $transaction_details =
            [
//                'payment' => $this->trans_type == "payment" ? trans("mobile.transaction.transaction_details.payment_status", ['amount' => number_format($this->amount, 2, '.', ''), 'refund_amount' => number_format($this->amount, 2, '.', '')]) : "",
            'payment' => $this->trans_type == "payment" ? trans("mobile.transaction.transaction_details.payment_status", ['amount' => number_format($this->amount, 2, '.', '')]) : "",
            'wallet_transfer' => $this->trans_type == "wallet_transfer"
                ? trans("mobile.transaction.transaction_details.wallet_transfer_status", [
                    'amount' => number_format($this->amount, 2, '.', ''),
                    'transfer_type_trans' => trans('mobile.transfers.wallet_transfer_methods.' . $this->transactionable?->wallet_transfer_method),
                    'to_user_identity_or_mobile_or_wallet_number' => @$wallet_transfer_method[$this->transactionable?->wallet_transfer_method]]) : "",
            'local_transfer' => $this->trans_type == "local_transfer" ? trans("mobile.transaction.transaction_details.local_transfer_status", ['amount' => number_format($this->amount, 2, '.', ''), 'beneficiary' => $this->transactionable?->beneficiary?->name, 'iban' => $this->transactionable?->beneficiary?->iban_number]) : "",
            'global_transfer' => $this->trans_type == "global_transfer" ? trans("mobile.transaction.transaction_details.global_transfer_status", ['amount' => $to_amount, 'currency' => $this->transactionable?->bankTransfer?->toCurrency?->currency_code, 'beneficiary' => $this->transactionable?->beneficiary?->name, 'country' => $this->transactionable?->beneficiary?->country?->name, 'recieve_option' => $this->transactionable?->bankTransfer?->recieveOption?->name, 'mtcn' => $this->transactionable?->bankTransfer?->mtcn_number]) : "",
            'charge' => $this->trans_type == "charge" ? trans("mobile.transaction.transaction_details.charge_status", ['amount' => number_format($this->amount, 2, '.', ''), 'method' => __('mobile.transaction.charge_types.' . $this->transactionable?->charge_type, ['card_number' => $last_card_number])]) : "",
            'money_request' => $this->trans_type == "money_request" ? trans("mobile.transaction.transaction_details.money_request_status", ['amount' => number_format($this->amount, 2, '.', ''), 'to_user_identity_or_mobile_or_wallet_number' => $wallet_transfer_method[$this->transactionable?->wallet_transfer_method]]) : "",
            'promote_package' => $this->trans_type == "promote_package" ? trans("mobile.transaction.transaction_details.promote_package_status", ['amount' => number_format($this->amount, 2, '.', ''), 'package_name' => $this->fromUser->citizen->enabledPackage->package_type, 'expired_date' => $this->fromUser->citizen->enabledPackage->end_at]) : "",

        ];
        $transfer_fee_upon = $this->when(in_array($this->trans_type, ['global_transfer', 'local_transfer']), (string)$this->transactionable?->fee_upon);
        $fee_amount = ($transfer_fee_upon == Transfer::FROM_USER) ? $this->fee_amount : 0;
        $total_amount = $this->amount + $fee_amount;
        return [
            'id' => $this->id,
            'trans_number' => (string)$this->trans_number,
            'main_label' => $this->getMainlabels(),
            'trans_type' => $this->trans_type,
            'trans_type_translate' => trans("mobile.transaction.transaction_types.{$this->trans_type}"),
            'trans_status' => $this->trans_status,
            'amount' => number_format($this->amount, 2, '.', ''),
            'fee_amount' => number_format($fee_amount, 2, '.', ''),
            'total_amount' => number_format($total_amount, 2, '.', ''), // new amount after add or sub fees
            'created_at' => $this->created_at_date_time,
            'invoice_number' => $this->when($this->trans_type == 'payment', (string)$this->transactionable?->invoice_number),
            'mtcn_number' => $this->when(in_array($this->trans_type, ['global_transfer', 'local_transfer']), (string)$this->transactionable?->bankTransfer?->mtcn_number),
            'trans_status_translate' => trans("mobile.transaction.status_cases.{$this->trans_status}"),
            'to_currency' => $this->transactionable?->bankTransfer?->toCurrency?->currency_code,
            'exchange_rate' => (string)$this->transactionable?->bankTransfer?->exchange_rate,
            'to_amount' => $to_amount,
            'transfer_fees' => number_format($this->transactionable?->transfer_fees, 2) ?? '0',
            'transfer_purpose' => $this->transactionable?->transferPurpose?->is_another == 1 ? $this->transactionable?->notes : $this->transactionable?->transferPurpose?->name,
            'recieve_option' => $this->transactionable?->bankTransfer?->recieveOption?->name,
            'qr_code' => asset($this->qr_path),
            'wallet_transfer_method' => $this->when($this->trans_type == 'wallet_transfer', $this->transactionable?->wallet_transfer_method),
            'wallet_transfer_method_translation' => $this->when($this->trans_type == 'wallet_transfer', trans('mobile.transfers.wallet_transfer_methods.' . $this->transactionable?->wallet_transfer_method)),
            'wallet_transfer_value' => $this->when($this->trans_type == 'wallet_transfer', $wallet_transfer_method[$this->transactionable?->wallet_transfer_method] ?? (string)$this->toUser?->citizenWallet?->wallet_number),
            'from_user' => UserResource::make($this->fromUser),
            'to_user' => UserResource::make($this->toUser),
            'beneficiary' => BeneficiaryResource::make($this->transactionable?->beneficiary),
            'notes' => $this->transactionable?->notes,
            'transaction_details' => (string)$transaction_details[$this->trans_type],
        ];
    }

    private function getMainlabels(): string
    {
        if (in_array($this->trans_type, Transaction::TRANSFERS)) {
            return trans('mobile.transaction.transaction_types.transfer');
        } elseif (in_array($this->trans_type, Transaction::PAYMENTS)) {
            return trans('mobile.transaction.transaction_types.payment');
        } elseif (in_array($this->trans_type, Transaction::PROMOTE_PACKAGE)) {
            return trans('mobile.transaction.transaction_types.promote_package');
        } elseif (in_array($this->trans_type, Transaction::CHARGE)) {
            return trans('mobile.transaction.transaction_types.charge');
        }
        return true;
    }
}
