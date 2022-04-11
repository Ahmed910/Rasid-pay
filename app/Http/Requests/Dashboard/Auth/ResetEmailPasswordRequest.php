<?php

namespace App\Http\Requests\Dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class ResetEmailPasswordRequest extends FormRequest
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
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
            'email' => ['required','email',function ($attribute, $value, $fail){
                $user = User::firstWhere('email', $value);

                if ($user && $user->ban_status != 'active') {
                    $fail(trans('auth.user_banned'));
                }
            }],
        ];
    }

}
