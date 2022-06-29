<?php

namespace App\Http\Requests\V1\Mobile\Profile;

use App\Http\Requests\ApiMasterRequest;

class UpdatePasswordRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => [
                'required',
                'min:6',
                function ($attribute, $value, $fail) {
                    if (!\Hash::check($value, auth()->user()->password)) {
                        $fail(trans('auth.wrong_old_password'));
                    }
                }
            ],
            'new_password' => 'required|min:8|different:current_password|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ];
    }
}
