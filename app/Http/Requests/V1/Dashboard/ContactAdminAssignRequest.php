<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Validation\Rule;

class ContactAdminAssignRequest extends ApiMasterRequest
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
    public function rules()
    {
        return [
            "assigned_to_id" => ["required","exists:users,id,user_type,admin"],
            "notes"          => ["nullable", "string"]
        ];
    }
}
