<?php

namespace App\Http\Requests\V1\Mobile;

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
            "fullname" => 'nullable|string|max:255',
            'email' => 'nullable|email|max:225',
            'phone' => 'nullable|numeric|min:20',
            "title" => 'required|string|max:255',
            "content" => 'required|string|max:300',
            "contact_type" => 'required|in:complain,inquiries,suggestions',
        ];
    }
}
