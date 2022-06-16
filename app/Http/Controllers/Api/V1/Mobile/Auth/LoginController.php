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
        return [
            'identity_number' => $request->identity_number,
            'password' => $request->password,
        ];
    }

    /**
     * @param LoginRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $this->getCredentials($request);

        return $this->checkIsUserValid($request);
        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.failed')], 406);
        }
        return $this->makeLogin($request, $user);

    }

    public function checkIsUserValid($request)
    {
        $user = User::firstWhere([
            'identity_number' => $request->identity_number,
            'user_type'       => 'citizen'
        ]);

        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }
        switch ($user) {
            case $user->register_status != 'completed':
                return response()->json(['status' => false, 'data' => [
                    'is_register_completed' => false,
                    'is_active' => null,
                    'ban_status' => null,
                    'ban_date' => null,
                ], 'message' => trans('auth.verify_phone')], 403);
            case $user->is_active == 0 :
                return response()->json(['status' => false, 'data' => [
                    'is_active' => false,
                    'is_register_completed' => null,
                    'ban_status' => null,
                    'ban_date' => null,
                ], 'message' => trans('auth.verify_phone')], 403);

            case $user->ban_status == 'permanent' :
                return response()->json(['status' => false, 'data' => [
                    'is_active' => null,
                    'is_register_completed' => null,
                    'ban_status' => 'permanent',
                    'ban_date' => null,
                ], 'message' => trans('auth.ban_permanent')], 403);

            case $user->ban_status == 'temporary' :
                return response()->json(['status' => false, 'data' => [
                    'is_active' => null,
                    'is_register_completed' => null,
                    'ban_status' => 'permanent',
                    'ban_date' => $user->ban_to,
                ], 'message' => trans('auth.ban_temporary')], 403);

        }
        return true;
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
            'message' => trans('auth.success_login_mobile',
                ['user' => $user->identity_number])]);
    }

    /**
     * @param SendCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetCode(SendCodeRequest $request)
    {
        return $this->checkIsUserValid($request);
        $user = User::firstWhere([
            'identity_number' => $request->identity_number,
            'user_type'       => 'citizen'
        ]);

        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }

        try {
            $code = 1111;
            if (setting('use_sms_service') == 'enable') {
               $code = generate_unique_code(User::class, 'phone', 4, 'numbers');
            }
            $user->update([$request->key_name => $code]);
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
