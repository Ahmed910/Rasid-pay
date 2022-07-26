<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;

class MoneyReqRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "amount_required" => 'required|min:1|max:10|regex:/^[\pN\,\.]+$/u',
            'phone' => ["required", "numeric", function ($attribute, $value, $fail) {
                if(!check_phone_valid($value)){
                    $fail(trans('mobile.validation.invalid_phone'));
                }
            }],
            "notes" => 'required|string|max:255',

        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'amount_required' => @$data['amount_required'] ? convert_arabic_number($data['amount_required']) : @$data['amount_required'],
            'phone' => @$data['phone'] ? filter_mobile_number($data['phone']) : @$data['phone']
        ]);
    }
}
