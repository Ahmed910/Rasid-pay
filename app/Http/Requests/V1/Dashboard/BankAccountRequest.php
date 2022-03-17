<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class BankAccountRequest extends ApiMasterRequest
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
        return [
//            "account_name" => ["required", "max:255"],
            "iban_number" => ["required", "max:255", "unique:bank_accounts,iban_number," . @$this->banck_account->id . ",id,bank_id," . @$this->bank_id],
            "contract_type" => ["required", "max:255", "in:pending,before_review,reviewed"],
            "bank_id" => ["required", "exists:banks,id"],
//            "user_id" => ["required", "exists:users,id"],


        ];
    }
}
