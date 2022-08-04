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
            "iban" => ['required', 'starts_with:SA', "size:24", 'alpha_num', "unique:vendors,iban," . @$this->vendor],
            "email" => ["required", "max:100", "email", "unique:vendors,email," . @$this->vendor],
            "phone" => ["required", "numeric", function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('mobile.validation.phone.invalid'));
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


    public function messages()
    {
        return [
            'iban_number.required' => __('dashboard.vendors.iban_number.required'),
            'iban_number.starts_with' => __('dashboard.vendors.iban_number.starts_with', ['starts_with' => 'SA']),
            'iban_number.size' => __('dashboard.vendors.iban_number.size', ['size' => '24']),
            'iban_number.unique' => __('dashboard.vendors.iban_number.unique'),
        ];
    }
}
