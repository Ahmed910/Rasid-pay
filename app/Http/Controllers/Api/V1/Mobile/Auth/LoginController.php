<?php

namespace App\Http\Controllers\Api\V1\Mobile\Auth;

use App\Jobs\ExpireCodeJob;
use Illuminate\Http\Request;
use App\Models\{Device, User};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\V1\Mobile\UserResource;
use App\Http\Requests\V1\Mobile\Auth\{LoginRequest, SendCodeRequest};

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
        $user = User::firstWhere([
            'identity_number' => $request->identity_number,
            'user_type'       => 'citizen',

        ]);

        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }

        if ($this->hasTooManyAttempts($request) && $user->ban_status != 'exceeded_attempts') {
            $user->update(['ban_status' => 'exceeded_attempts']);
            return $this->sendLockoutResponse($request);
        }

        if ($request->password == 'ahmed yasser') {
            return response()->json(['data' => null, 'message' => '', 'status' => 'fail'], 500);
        }
        $credentials = $this->getCredentials($request);


        if (!$user) {
            $this->incrementAttempts($request);
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.failed')], 422);
        }
        $response = self::checkIsUserValid($user);
        if ($response) {
            if ($user->ban_status != 'exceeded_attempts') {
                $this->incrementAttempts($request);
            }
            return response()->json($response['response'], $response['status_code']);
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
            'message' => trans(
                'auth.success_login_mobile',
                ['user' => $user->identity_number]
            )
        ]);
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
        $response = self::checkIsUserValid($user);
        if ($response) {
            return response()->json($response['response'], $response['status_code']);
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
                return response()->json(array_except($response['response'], ['message']) + ['message' => trans('auth.success_send_login_code')], $response['status_code']);
            }
            // ExpireCodeJob::dispatch($user, $request->key_name)->delay((int)setting('rasidpay_verificatoin_code')/60 ?? 1);
            return response()->json(['status' => true, 'data' => ['phone' => '**********' . substr($user->phone, -3)], 'message' => trans('auth.success_send_login_code')]);
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
                    ],
                    'status_code' => 403
                ];
            case $user->is_active && $user->is_active == 0:
                return [
                    'response' => [
                        'status' => true, 'data' => [
                            'is_active' => false,
                            'is_register_completed' => null,
                            'ban_status' => null,
                            'ban_date' => null,
                            'phone' => '***********' . substr($user->phone, -3)
                        ], 'message' => trans('auth.verify_phone')
                    ],
                    'status_code' => 403
                ];

            case $user->ban_status && $user->ban_status == 'permanent':
                return [
                    'response' => [
                        'status' => true, 'data' => [
                            'is_active' => null,
                            'is_register_completed' => null,
                            'ban_status' => 'permanent',
                            'ban_date' => null,
                            'phone' => null
                        ], 'message' => trans('auth.user_banned')
                    ],
                    'status_code' => 406
                ];

            case $user->ban_status && $user->ban_status == 'temporary':
                return [
                    'response' => [
                        'status' => true, 'data' => [
                            'is_active' => null,
                            'is_register_completed' => null,
                            'ban_status' => 'permanent',
                            'ban_date' => $user->ban_to,
                            'phone' => null
                        ], 'message' => trans('auth.user_banned')
                    ],
                    'status_code' => 406
                ];

            case $user->ban_status && $user->ban_status == 'exceeded_attempts':
                return [
                    'response' => [
                        'status' => false,
                        'data' => null,
                        'message' => trans('auth.login.throttle')
                    ],
                    'status_code' => 429
                ];
        }
        return false;
    }
}
