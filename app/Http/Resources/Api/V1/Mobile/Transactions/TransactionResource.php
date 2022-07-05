<?php

namespace App\Http\Resources\Api\V1\Mobile\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\Mobile\{UserResource};
use App\Http\Resources\Api\V1\Mobile\Beneficiary\BeneficiaryResource;

class TransactionResource extends JsonResource
{

    public function toArray($request)
    {
        $wallet_transfer_method = [
            'phone'          => $this->transactionable?->wallet_transfer_method =='phone' ? $this->toUser->phone :"" ,
            'identity_number'=> $this->transactionable?->wallet_transfer_method =='identity_number' ? $this->toUser->identity_number :"",
            'wallet_number'  => $this->transactionable?->wallet_transfer_method =='wallet_number' ? $this->toUser->citizenWallet?->wallet_number :"" ,
        ];

        $transaction_details =
        [
            'payment'          => $this->trans_type == "payment"  ? trans("mobile.transaction.payment_status", [ 'amount' => $this->amount, 'refund_amount' => $this->amount ]) : "",
            'wallet_transfer'  => $this->trans_type == "wallet_transfer"  ? trans("mobile.transaction.wallet_transfer_status",  [ 'amount' => $this->amount,'to_user_identity_or_mobile_or_wallet_number' => $wallet_transfer_method[$this->transactionable?->wallet_transfer_method] ]) : "",
            'local_transfer'   => $this->trans_type == "local_transfer"  ? trans("mobile.transaction.local_transfer_status", [ 'amount' => $this->amount, 'beneficiary' => $this->transactionable?->beneficiary->name, 'iban' => $this->transactionable?->beneficiary->iban_number ]): "" ,
            'global_transfer'  => $this->trans_type == "global_transfer"  ? trans("mobile.transaction.global_transfer_status", [ 'amount' => $this->amount, 'currency' =>$this->transactionable?->bankTransfer?->toCurrency?->currency_code,'beneficiary' => $this->transactionable?->beneficiary?->name, 'country' =>$this->transactionable?->beneficiary?->country?->name , 'recieve_option'=>$this->transactionable?->bankTransfer?->recieveOption?->name ,'mtcn' =>$this->transactionable?->bankTransfer?->mtcn_number ]) : "",
            'charge'           => $this->trans_type == "charge"  ? trans("mobile.transaction.charge_status", [ 'amount' => $this->amount ,'method' =>$this->transactionable?->charge_type ]) : "",
            'money_request'    => $this->trans_type == "money_request" ? trans("mobile.transaction.money_request_status", [ 'amount' => $this->amount, 'to_user_identity_or_mobile_or_wallet_number' =>  $wallet_transfer_method[$this->transactionable?->wallet_transfer_method] ]):"" ,
            'promote_package'  => $this->trans_type == "promote_package" ? trans("mobile.transaction.promote_package_status", [ 'amount' => $this->amount,'package_name' => $this->fromUser->citizenPackages->package->name, 'expired_date' => $this->fromUser->citizenPackages->end_at->format('y/m/d') ]):"" ,

        ];
        return [
            'id' => $this->id,
            'trans_number' => $this->trans_number,
            'amount' => $this->amount,
            'trans_type' => $this->trans_type,
            'invoice_number' => $this->when($this->trans_type == 'payment', (string)$this->transactionable?->invoice_number),
            'mtcn_number' => $this->when(in_array($this->trans_type, ['global_transfer','local_transfer']), (string)$this->transactionable?->bankTransfer?->mtcn_number),
            'trans_type_translate' => trans("mobile.transaction.transaction_types.{$this->trans_type}"),
            'trans_status' => $this->trans_status,
            'trans_status_translate' => trans("mobile.transaction.status_cases.{$this->trans_status}"),
            'to_currency' => $this->transactionable?->bankTransfer?->toCurrency?->currency_code,
            'exchange_rate' => $this->transactionable?->bankTransfer?->exchange_rate,
            'to_amount' => $this->amount * $this->transactionable?->bankTransfer?->exchange_rate,
            'transfer_fees' => $this->transactionable?->transfer_fees ?? 0,
            'total_amount' => (string)($this->amount + $this->transfer_fees),
            'transfer_purpose' => $this->transactionable?->transferPurpose?->name,
            'recieve_option' => $this->transactionable?->bankTransfer?->recieveOption?->name,
            'qr_code' => asset($this->qr_path),
            'date' => $this->created_at,
            'from_user' => UserResource::make($this->fromUser),
            'to_user' => UserResource::make($this->toUser),
            'beneficiary' => BeneficiaryResource::make($this->transactionable?->beneficiary),
            'notes' =>  $this->transactionable?->notes,
            'transaction_details' => (string)$transaction_details[$this->trans_type] ,
        ];
    }
}
