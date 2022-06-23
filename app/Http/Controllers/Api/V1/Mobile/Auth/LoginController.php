<?php

namespace App\Http\Controllers\Api\V1\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Auth\{LoginRequest, SendCodeRequest};
use App\Http\Resources\Api\V1\Mobile\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Models\{Device, User};
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ThrottlesAttempts;
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
        if($this->hasTooManyAttempts($request))
        {
           return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
        $user = User::firstWhere([
            'identity_number' => $request->identity_number,
            'user_type'       => 'citizen',

        ]);

        if (!$user) {
            $this->incrementAttempts($request);
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.failed')], 422);
        }
        $response = self::checkIsUserValid($user);
        if ($response) {
            $this->incrementAttempts($request);
            return response()->json($response['response'],403);
        }
        if (!Auth::attempt($credentials)) {
            $this->incrementAttempts($request);
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.failed')], 406);
        }
        $this->clearAttempts($request);
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
        return UserResource::make($user->load('citizen'))->additional([
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
            $response = self::checkIsUserValid($user);
            if ($response) {
                return response()->json(array_except($response['response'],['message']) + ['message' => trans('auth.success_send_login_code')],403);
            }
            return response()->json(['status' => true, 'data' => ['phone' => '**********' . substr($user->phone, -4)], 'message' => trans('auth.success_send_login_code')]);
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


    public static function checkIsUserValid($user)
    {
        switch ($user) {
            case $user->register_status && $user->register_status != 'completed':
                $code = 1111;
                if (setting('use_sms_service') == 'enable') {
                   $code = generate_unique_code(User::class, 'phone', 4, 'numbers');
                }
                $user->update(['verified_code' => $code]);
                return [
                        'response' => [
                            'status' => true, 'data' => [
                            'is_register_completed' => false,
                            'is_active' => null,
                            'ban_status' => null,
                            'ban_date' => null,
                            'phone' => '***********' . substr($user->phone, -3)
                        ], 'message' => trans('auth.verify_phone')
                    ]
                ];
            case $user->is_active && $user->is_active == 0 :
                return [
                        'response' => [
                            'status' => true, 'data' => [
                            'is_active' => false,
                            'is_register_completed' => null,
                            'ban_status' => null,
                            'ban_date' => null,
                            'phone' => '***********' . substr($user->phone, -3)
                        ], 'message' => trans('auth.verify_phone')]
                    ];

            case $user->ban_status && $user->ban_status == 'permanent' :
                return [
                        'response' => [
                            'status' => true, 'data' => [
                            'is_active' => null,
                            'is_register_completed' => null,
                            'ban_status' => 'permanent',
                            'ban_date' => null,
                            'phone' => null
                        ], 'message' => trans('auth.ban_permanent')
                    ]
                ];

            case $user->ban_status && $user->ban_status == 'temporary' :
                return [
                        'response' => [
                            'status' => true, 'data' => [
                            'is_active' => null,
                            'is_register_completed' => null,
                            'ban_status' => 'permanent',
                            'ban_date' => $user->ban_to,
                            'phone' => null
                        ], 'message' => trans('auth.ban_temporary')
                    ]
                ];

        }
        return false;
    }
}
