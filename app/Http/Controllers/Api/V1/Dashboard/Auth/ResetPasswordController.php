<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\Auth\{ResetPasswordRequest, CheckResetCodeRequest};
use App\Models\{User};
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function CheckResetCode(CheckResetCodeRequest $request)
    {
        $user = User::firstWhere(['reset_token' => $request->_token]);
        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists'),'errors' => []], 422);
        }

        return response()->json(['status' => true, 'data' => ['_token' => $user->reset_token], 'message' => trans('auth.account_is_true')]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::firstWhere(['reset_token' => $request->_token]);
        $user_data = ['reset_token' => null];
        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists'),'errors' => []], 422);
        } elseif (!$user->phone_verified_at) {
            $user_data += ['password' => $request->password, 'verified_code' => null, 'is_active' => true, 'phone_verified_at' => now()];
        } elseif ($user->phone_verified_at) {
            $user_data += ['password' => $request->password, 'reset_code' => null];
        }
        $user->update($user_data);

        return response()->json(['status' => true, 'data' => null, 'message' => trans('auth.success_change_password')]);
    }
}
