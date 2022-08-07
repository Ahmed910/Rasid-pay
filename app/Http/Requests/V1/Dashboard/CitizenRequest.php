<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class CitizenRequest extends ApiMasterRequest
{
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
             "phone" => ["required", "numeric", "digits_between:9,20", 'starts_with:9665,5', function ($attribute, $value, $fail) {
                 if(!check_phone_valid($value)){
                     $fail(trans('mobile.validation.invalid_phone'));
                 }
             },'unique:users,phone,'.$this->citizen]
         ];
     }
}
