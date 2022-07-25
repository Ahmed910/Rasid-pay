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
        $rules = [
            'type' => "required|in:" . join(",", Vendor::TYPES),
            'commercial_record' => ["required", "numeric", "digits_between:10,20", "unique:vendors,commercial_record," . @$this->vendor],
            'tax_number' => "required|digits_between:10,20|numeric|unique:vendors,tax_number," . @$this->vendor,
            'is_support_maak' => "required|in:1,0",
            'is_active' => "nullable|in:1,0",
//            "iban" => ['required', "unique:vendors,iban","size:24" . @$this->vendor, function ($attribute, $value, $fail) {
//                if (!check_iban_valid($value, 'sa')) {
//                    $fail(trans('mobile.validation.invalid_iban'));
//                }
//            }],
            'iban' => 'required',
            "email" => ["required", "max:100", "email", "unique:vendors,email," . @$this->vendor],
            "phone" => ["required", "numeric",'regex:/^(009665|9665|00966|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', 'unique:vendors,phone,' . $this->vendor],
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
}
