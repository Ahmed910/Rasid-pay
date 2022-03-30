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
            "iban_number" => ["required", "min:6", "max:24", "unique:bank_accounts,iban_number," . @$this->banck_account->id . ",id,bank_id," . @$this->banck_account->bank_id],
            "contract_type" => [ "nullable","max:255", "in:pending,before_review,reviewed"],
            "bank_id" => ["required", "exists:banks,id"],


        ];
    }
}
