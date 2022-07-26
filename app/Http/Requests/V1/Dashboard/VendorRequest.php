<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Vendor\Vendor;

class VendorRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         *, function ($attribute, $value, $fail) {
         *    if (!check_iban_valid($value, ($this->benficiar_type == Beneficiary::LOCAL_TYPE ? 'sa' : null))) {
         *        $fail(trans('mobile.validation.invalid_iban'));
         *    }
         *}]
         */

        $rules = [
            'type' => "required|in:" . join(",", Vendor::TYPES),
            'commercial_record' => ["required", "numeric", "digits_between:10,20", "unique:vendors,commercial_record," . @$this->vendor],
            'tax_number' => "required|digits_between:10,20|numeric|unique:vendors,tax_number," . @$this->vendor,
            'is_support_maak' => "required|in:1,0",
            'is_active' => "nullable|in:1,0",
            "iban" => ['required', 'alpha_num', "size:24", "unique:vendors,iban," . @$this->vendor],
            "email" => ["required", "max:100", "email", "unique:vendors,email," . @$this->vendor],
            "phone" => ["required", "numeric", function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('mobile.validation.invalid_phone'));
                }
            }, 'unique:vendors,phone,' . $this->vendor],
            'logo' => (!$this->isMethod('put')) ? "required|" : "nullable|" . 'mimes:jpeg,jpg,png,suv,heic',
            'commercial_record_image' => (!$this->isMethod('put')) ? "required|" : "nullable|" . 'mimes:jpeg,jpg,png,suv,heic',
            'tax_number_image' => 'nullable|mimes:jpeg,jpg,png,suv,heic',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"] = "array";
            $rules["$locale.name"] = "required|between:2,100|regex:/^[\pL\pN\s\-\_]+$/u|unique:vendor_translations,name," . @$this->vendor . ",vendor_id";
        }

        return $rules;

    }

    protected function prepareForValidation()
    {
        $data = $this->all();
        $this->merge([
            'phone' => @$data['phone'] ? filter_mobile_number($data['phone']) : @$data['phone']
        ]);
    }
}
