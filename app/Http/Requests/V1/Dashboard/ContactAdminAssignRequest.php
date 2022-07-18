<?php

namespace App\Http\Requests\V1\dashboard;

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
            "admin_id" => ["required",
                Rule::exists('users', 'id')
                    ->wherein('user_type', ["admin", "super_admin"])],
            "notes" => ["nullable", "string"],
        ];
    }
}
