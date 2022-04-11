<?php

namespace App\Http\Requests\Dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class LoginRequest extends FormRequest
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
            'password' => 'required|string',
            'username' => ['required','numeric',function ($attribute, $value, $fail){
                $user = User::firstWhere('login_id', $value);
                if ($user && $user->ban_status != 'active') {
                    $fail(trans('auth.user_banned'));
                }
            }],
        ];
    }

}
