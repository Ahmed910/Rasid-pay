<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;

class MoneyReqRequest extends ApiMasterRequest
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
            "amount_required" => 'required|min:1|max:10|regex:/^[\pN\,\.]+$/u',
            'phone' => 'required|numeric|exists:users,phone',
            "notes" => 'required|string|max:255',

        ];
    }
}
