<?php

namespace App\Http\Requests\V1\Dashboard;

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
            "admin_id" => ["required", "exists:users,id"],
            "reply" => ["required", "string"],
        ];
    }
}
