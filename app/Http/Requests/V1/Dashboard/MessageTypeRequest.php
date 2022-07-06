<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class MessageTypeRequest extends ApiMasterRequest
{
    public function rules()
    {
        $rules = [
            "is_active" => "in:0,1",
            'admins' => 'required|array',
            'admins.*' => 'exists:users,id,user_type,admin'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]         = "array";
            $rules["$locale.name"]    = "required|between:2,100|regex:/^[\pL\pN\s\-\_]+$/u|unique:message_type_translations,name," . @$this->messageType  . ",message_type_id";
        }

        return $rules;
    }
}
