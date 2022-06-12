<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;

class WalletBinRequest extends ApiMasterRequest
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
            'wallet_bin'=>'required|numeric|digits:6'
        ];
    }
}
