<?php

namespace App\Http\Requests\Mobile;

use App\Http\Requests\ApiMasterRequest;

class ContactRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "fullname" => 'required|string|min:2|max:100',
            'email' => ["required","email","regex:/^[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/","max:100"],
            'phone' => ["required", "numeric", function ($attribute, $value, $fail) {
                if (!check_phone_valid($value)) {
                    $fail(trans('mobile.validation.phone.invalid'));
                }
            }],
            "content" => 'required|string|min:10|max:300',
            "message_type_id" => 'required|exists:message_types,id',
        ];
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
            'fullname.required'        =>  __('mobile.validation.fullname.required'),
            'fullname.min'             =>  __('mobile.validation.fullname.min'),
            'email.required'           =>  __('mobile.validation.email.required'),
            'email.email'              =>  __('mobile.validation.email.email'),
            'email.regex'              =>  __('mobile.validation.email.regex'),
            'phone.required'           =>  __('mobile.validation.phone.required'),
            'phone.numeric'            =>  __('mobile.validation.phone.invalid'),
            'content.required'         =>  __('mobile.contacts.validation.content.required'),
            'content.min'              =>  __('mobile.contacts.validation.content.min'),
            'message_type_id.required' =>  __('mobile.contacts.validation.message_type.required'),
            'message_type_id.exists' =>  __('mobile.contacts.validation.message_type.exists'),
        ];
    }
}
