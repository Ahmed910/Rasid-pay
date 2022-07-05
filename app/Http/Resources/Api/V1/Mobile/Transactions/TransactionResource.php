<?php

namespace App\Http\Resources\Api\V1\Mobile\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\Mobile\{Beneficiary\BeneficiaryResource, UserResource};
use App\Models\Transaction;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->when($request->is('*/transactions'),$this->id),
            'id' => $this->id,
            'trans_number' =>$this->when($request->is('*/transactions'), (string)$this->trans_number),
            'amount' => (string)$this->amount,
            'main_label' => $this->when($request->is('*/transactions'),$this->getMainlabels()),
           'trans_type' =>$this->when($request->is('*/transactions'), $this->trans_type),
            'invoice_number' => $this->when($this->trans_type == 'payment', (string)$this->transactionable?->invoice_number),
            'mtcn_number' => $this->when(in_array($this->trans_type, ['global_transfer', 'local_transfer']), (string)$this->transactionable?->bankTransfer?->mtcn_number),
            'trans_type_translate' =>$this->when($request->is('*/transactions'), trans("mobile.transaction.transaction_types.{$this->trans_type}")),
            'trans_status' =>$this->when($request->is('*/transactions'), $this->trans_status),
            'trans_status_translate' => trans("mobile.transaction.status_cases.{$this->trans_status}"),
            'to_currency' => $this->transactionable?->bankTransfer?->toCurrency?->currency_code,
            'exchange_rate' => (string) $this->transactionable?->bankTransfer?->exchange_rate,
            'toTal_amount' => (string) ($this->amount * $this->transactionable?->bankTransfer?->exchange_rate),
            'transfer_fees' => (string) $this->transactionable?->transfer_fees ?? 0,
            'total_amount' =>$this->when($request->is('*/transactions'), (string)($this->amount + $this->transfer_fees)),
            'transfer_purpose' => $this->transactionable?->transferPurpose?->name,
            'recieve_option' => $this->transactionable?->bankTransfer?->recieveOption?->name,
            'qr_code' => asset($this->qr_path),
            'created_at' =>$this->when($request->is('*/transactions'), $this->created_at),
            'wallet_transfer_method' => $this->when($this->trans_type == 'wallet_transfer', $this->transactionable?->wallet_transfer_method),
            'wallet_transfer_value' => $this->when($this->trans_type == 'wallet_transfer', $this->toUser?->{$this->transactionable?->wallet_transfer_method} ?? (string)$this->toUser?->citizenWallet?->wallet_number),
            'from_user' => UserResource::make($this->fromUser),
            'to_user' => UserResource::make($this->toUser),
            'beneficiary' => BeneficiaryResource::make($this->transactionable?->beneficiary),
            'notes' => $this->transactionable?->notes,
        ];
    }

    private function getMainlabels() : string
    {
        if(in_array($this->trans_type,Transaction::TRANSFERS)){
            return trans('mobile.transaction.transfer');
        }elseif(in_array($this->trans_type,Transaction::PAYMENTS)){
            return trans('mobile.transaction.payment');
        }elseif(in_array($this->trans_type,Transaction::CHARGE)){
            return trans('mobile.transaction.charge');
        }
    }
}
