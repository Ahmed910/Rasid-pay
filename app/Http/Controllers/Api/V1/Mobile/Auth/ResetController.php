<?php

namespace App\Http\Controllers\Api\V1\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Auth\ResetPasswordRequest;
use App\Http\Requests\V1\Mobile\Auth\ResetRequest;
use App\Models\User;

class ResetController extends Controller
{
    public function checkIdentityNumber(ResetRequest $request)
    {
        $user = User::firstWhere([
            'identity_number' => $request->identity_number,
            'user_type'       => 'citizen'
        ]);
        if (!$user)
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);

        if (setting('use_sms_service') == 'enable') {
            $code = generate_unique_code(User::class, 'identity_number', 4, 'numbers');
        }
        //TODO: send sms with code
        $user->update([
            'reset_code' => $code,
        ]);

        return response()->json(['status' => true, 'data' => ['_token' => $code], 'message' => trans('auth.account_is_true')]);
    }

    public function updatePassword(ResetPasswordRequest $request)
    {
        $user = User::firstWhere([
            'identity_number' => $request->identity_number,
            'user_type'       => 'citizen'
        ]);


        if (!$user)
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);

        $user->update([
            'password' => $request->password,
        ]);

        return response()->json([
            'status' => true,
            'data'   => null,
            'message' => trans('auth.success_change_password')
        ]);
    }
}
