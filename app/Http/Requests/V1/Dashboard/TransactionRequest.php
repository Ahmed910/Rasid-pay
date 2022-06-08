<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class TransactionRequest extends ApiMasterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if ($this->transaction) {
            $data = [
                'transaction_id' => 'nullable|min:2|max:255|unique:transactions,transaction_id,' . @$this->transaction->id,
                'transaction_data' => 'nullable|string',
            ];
        } else {
            $data = [
                "package_id" => "required|exists:packages,id,deleted_at,NULL",
                "from_user_id" => "required|exists:users,id,user_type,citizen,ban_status,active",
                "to_user_id" => "nullable|exists:clients,id",
                "amount" => "required|numeric",
                "gift_balance" => "required|numeric",
                "total_amount" => "required|numeric",
            ];
        }


        $rules = [
            "type" => "nullable|in:payment,wallet_transfer,bank_transaction,receive_credit,wallet_charge,upgrade_card",
            "status" => "nullable|in:success,fail,pending,received,cancel",
            "action_type" => "nullable|string|min:2|max:255",
            "qr_code" => "nullable|string|min:2|max:255",
        ] + $data;
        return $rules;
    }
}
