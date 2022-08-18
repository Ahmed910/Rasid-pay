<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class ContactReplyRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "contact_id" => ["required", "exists:contacts,id"],
            "reply" => ["required", "string"],
        ];
    }

    public function messages()
    {
        $validation = 'dashboard.contact.validation';

        $validation_messages = [

            'contact_id.required' => trans($validation.'.contact_id.required'),
            'contact_id.unique' => trans($validation.'.contact_id.unique'),
             'reply.required' => trans($validation.'.reply.required'),
             'reply.string' => trans($validation.'.reply.string'),

        ];



        return $validation_messages;
    }
}
