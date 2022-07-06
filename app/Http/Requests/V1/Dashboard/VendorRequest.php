<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Vendor\Vendor;

class VendorRequest extends ApiMasterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ruls = [
            'type' => "required|in:" . join(",", Vendor::TYPES),
            'commercial_record' => ["string", "max:10", "unique:vendors,commercial_record," . @$this->vendor],
            'tax_number' => "required|max:15|string|unique:vendors,tax_number," . @$this->client . ",user_id",
            'is_support_maak' => "required|in:1,0",
            'is_active' => "nullable|in:1,0",
            "iban" => "", // TODO
            "email" => ["nullable", "max:255", "email", "unique:vendors,email," . @$this->vendor],
            "phone" => ["nullable", "required", "numeric", "digits_between:9,20", 'starts_with:9665,05', 'unique:vendor,phone,' . $this->vendor]
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"] = "array";
            $rules["$locale.name"] = "required|between:2,100|regex:/^[\pL\pN\s\-\_]+$/u|unique:vendor_translations,name," . @$this->vendor . ",vendor_id";
        }

    }
}
