<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use App\Models\BankAccount;
use Illuminate\Validation\Rule;

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

            "iban_number" => ["required", "min:6", "max:24", function ($attribute, $value, $fail) {
                $bankacc = BankAccount::where("bank_id", $this->bank_id)->where("iban_number", $this->iban_number)?->get();
                $thisuser = $this->citizen ?? $this->client;
                if (isset($thisuser)) {
                    $user = $bankacc?->first()?->user_id;
                    if ($thisuser != $user && count($bankacc) > 0) $fail(trans("validation.unique"));
                } else     !count($bankacc) > 0 ?: $fail(trans("validation.unique"));
            }],
            "contract_type" => ["nullable", "max:255", "in:pending,before_review,reviewed"],
            "bank_id" => ["required", "exists:banks,id"],


        ];
    }
}
