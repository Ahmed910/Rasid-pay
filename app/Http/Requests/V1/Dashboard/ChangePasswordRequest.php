<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class ChangePasswordRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['required',function ($attribute, $value, $fail) {
                if (! \Hash::check($value, auth()->user()->password)) {
                    $fail(trans('auth.password'));
                }
            }],
            'password' => 'required',
        ];
    }
}
