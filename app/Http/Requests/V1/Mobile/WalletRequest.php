<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;

class WalletRequest extends ApiMasterRequest
{
    public function rules()
    {
        $rules = [
            // in citizen wallet
            "amount" => ['required', 'regex:/^\\d{1,5}$|^\\d{1,5}\\.\\d{0,2}$/', 'numeric', 'gte:'. (setting('rasidpay_inttransfer_minvalue') ?? 10).'', 'lte:'. (setting('rasidpay_walletcharge_maxvalue')??50000).''],
            //card information
            'is_card_saved' => 'required_without:card_id|in:0,1',
            'card_id' => 'nullable|required_without:charge_type|exists:cards,id,user_id,' . auth()->id(),
            'card_name' => 'required_if:is_card_saved,1|string|max:255',
        ];

        if (!$this->card_id) {
            $rules += [
                'owner_name' => 'required|string|max:255',
                'card_type' => 'required|in:visa,mastercard,american_express',
                'card_number' => 'required|numeric|digits:16',
                'expire_at' => 'required|date_format:m/y|after:today',
                'charge_type' => 'required|in:nfc,manual,scan',
            ];
        }
        return $rules;
    }


    protected function prepareForValidation()
    {
        // Visa cards begin with a 4 and have 13 or 16 digits
        // Mastercard cards begin with a 5 and has 16 digits
        // American Express cards begin with a 3, followed by a 4 or a 7 has 15 digits
        // Discover cards begin with a 6 and have 16 digits
        // Diners Club and Carte Blanche cards begin with a 3, followed by a 0, 6, or 8 and have 14 digits

        $data = $this->all();
        if (isset($this->is_card_saved) && @$data['card_number']) {
            $card_type = 'unknown';
            switch ($data['card_number']) {
                case substr($data['card_number'], 0, 1) == 4:
                    $card_type = 'visa';
                    break;
                case substr($data['card_number'], 0, 1) == 5:
                    $card_type = 'mastercard';
                    break;
                case substr($data['card_number'], 0, 1) == 3 && in_array(substr($data['card_number'], 1, 1), [4, 7]):
                    $card_type = 'american_express';
                    break;
            }
            $this->merge([
                'card_type' => $card_type,
                'amount' => @$data['amount'] ? convert_arabic_number($data['amount']) : @$data['amount'],
                'card_number' => @$data['card_number'] ? convert_arabic_number($data['card_number']) : @$data['card_number'],
            ]);
        }
    }

    public function messages()
    {
        return [
            'expire_at.after' => trans('mobile.validation.after_today'),
            'expire_at.date_format' => trans('mobile.validation.date_format'),
            'card_name.required_if' => trans('mobile.validation.card_name'),
            'card_number.required_if' => trans('mobile.validation.required_card_number'),
            'card_number.digits' =>  trans('mobile.validation.card_number_digits'),
            'expire_at.required_if' =>  trans('mobile.validation.expire_at'),
        ];
    }
}
