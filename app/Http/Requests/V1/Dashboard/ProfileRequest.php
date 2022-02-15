<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends ApiMasterRequest
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


    public function rules()
    {
        return [
            'fullname' => 'required|string|max:225',
            'email' => 'required|email|max:225|unique:users,email,' . auth()->id(),
            'phone' => 'required|numeric|min:20|unique:users,phone,' . auth()->id(),
            'whatsapp' => 'required|max:20|unique:users,whatsapp,' . auth()->id(),
            'identity_number' => 'required|numeric|min:20|unique:users,identity_number,' . auth()->id(),
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'date_of_birth_hijri' => 'required|date',
            "image" =>  'image|max:2048'
        ];
    }
}
