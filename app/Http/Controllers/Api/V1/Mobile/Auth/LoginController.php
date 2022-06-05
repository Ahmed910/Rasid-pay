<?php

namespace App\Http\Controllers\Api\V1\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Auth\LoginRequest;
use App\Http\Requests\V1\Mobile\Auth\SendCodeRequest;
use App\Http\Resources\Mobile\UserResource;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    private function getCredentials(Request $request)
    {
        $credentials = [];
        $login = 'identity_number';
        $credentials[$login] = $request->identity_number;
        $credentials['password'] = $request->password;
        return $credentials;
    }

    /**
     * @param LoginRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $this->getCredentials($request);
        $user = User::firstWhere('identity_number', $request->identity_number);
        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }
        switch ($user) {
            case $user->is_active == 0 :
                return response()->json(['status' => false, 'data' => [
                    'is_active' => false,
                    'ban_status' => null,
                    'ban_date' => null,
                ], 'message' => trans('auth.verify_phone')], 403);

            case $user->ban_status == 'permanent' :
                return response()->json(['status' => false, 'data' => [
                    'is_active' => null,
                    'ban_status' => 'permanent',
                    'ban_date' => null,
                ], 'message' => trans('auth.ban_permanent')], 403);

            case $user->ban_status == 'temporary' :
                return response()->json(['status' => false, 'data' => [
                    'is_active' => null,
                    'ban_status' => 'permanent',
                    'ban_date' => $user->ban_to,
                ], 'message' => trans('auth.ban_temporary')], 403);
        }
        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.failed')], 406);
        }
        return $this->makeLogin($request, $user);

    }

    /**
     * @param $request
     * @param $user
     * @param bool $login_code_required
     * @return UserResource
     */
    private function makeLogin($request, $user)
    {
        $user->devices()->where('device_token', "<>", $request->device_token)->delete();
        $token = $user->createToken('RasidBackApp')->plainTextToken;
        if ($request->only(['device_token', 'device_type'])) {
            $user->devices()->firstOrCreate($request->only(['device_token', 'device_type']));
        }
        data_set($user, 'token', $token);
        return UserResource::make($user)->additional([
            'status' => true,
            'message' => trans('auth.success_login',
                ['user' => $user->identity_number])]);
    }

    /**
     * @param SendCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetCode(SendCodeRequest $request)
    {
        $user = User::firstWhere('phone', $request->phone);
        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }
        try {
            $code = 111111;
            if (setting('use_sms_service') == 'enable') {
               $code = generate_unique_code(User::class, 'phone', 6, 'numbers');
            }
            $user->update(['reset_code' => $code]);
            // TODO::send code for user by sms
            return response()->json(['status' => true, 'data' => null, 'message' => trans('auth.success_send_login_code')]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.fail_send')], 422);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $device = Device::where([
            'user_id' => $user->id,
            'device_token' => $request->device_token,
            'device_type' => $request->device_type
        ])->first();
        if ($device) {
            $device->delete();
        }
        $user->currentAccessToken()->delete();
        return response()->json(['status' => true, 'data' => null, 'message' => trans('auth.logout_waiting_u_another_time')]);
    }
}
