<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CitizenPhoneRequest extends FormRequest
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
     protected function prepareForValidation()
     {
         $data = $this->all();

         $this->merge([
             'phone' => @$data['phone'] ? convert_arabic_number($data['phone']) : @$data['phone'],
         ]);
     }

     /**
      * Get the validation rules that apply to the request.
      *
      * @return array
      */
     public function rules()
     {
         return [
             "phone" => ["required", "numeric", "digits_between:7,20", 'starts_with:9665,05', function ($attribute, $value, $fail) {
                 if(!check_phone_valid($value)){
                     $fail(trans('mobile.validation.invalid_phone'));
                 }
             },'unique:users,phone,'.$this->citizen]
         ];
     }
}
