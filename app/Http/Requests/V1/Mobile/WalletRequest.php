<?php

namespace App\Http\Requests\V1\Mobile;
use App\Http\Requests\ApiMasterRequest;

class WalletRequest extends ApiMasterRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // in citizen wallet
            "amount" => "required|numeric|min:0",
            'user_id' => 'required|exists:users,id,user_type,citizen',

            // in transactions
            "trans_type" => "nullable|in:wallet_charge",

            //card information
            'owner_name' => 'required_if:is_card_saved,1|string|max:255',
            'card_name' => 'required_if:is_card_saved,1|string|max:255',
            'card_number' => 'required_if:is_card_saved,1|numeric|unique:cards|digits:16',
            'expire_at' => 'required_if:is_card_saved,1|date|max:25|after:today',
        ];
    }
}
