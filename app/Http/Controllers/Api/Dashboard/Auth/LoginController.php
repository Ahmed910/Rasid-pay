<?php

namespace App\Http\Controllers\Api\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\{LoginRequest,
    LogoutRequest,
    OTPLoginRequest,
    ResendCodeRequest,
    SendCodeRequest};
use App\Http\Resources\Api\Dashboard\UserResource;
use App\Models\{Device, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(LoginRequest $request)
    {
        $credentials = $this->getCredentials($request);
        $user = User::whereIn('user_type', ['admin', 'superadmin'])->when(array_key_exists('login_id', $credentials), function ($q) use ($request) {
            $q->where('login_id', $request->username);
        })->when(array_key_exists('phone', $credentials), function ($q) use ($request) {
            $q->where('phone', $request->username);
        })->first();
        if ($user && $user->user_type == 'admin' && !$user->permissions()->exists()) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.failed')], 401);
        }
        if ($user && $user->is_login_code && \Hash::check($request->password, $user->password)) {
            $code = $this->generateCode(['send_type' => 'phone'], $user, 'login_code');
            $reset_token = generate_unique_code(User::class, 'reset_token', 100);
            $user->update(['login_code' => $code, 'reset_token' => $reset_token]);
            // Send SMS CODE
            return response()->json(['status' => true, 'data' => ['_token' => $user->reset_token], 'message' => trans('auth.success_send_login_code'), 'dev_message' => $code, 'login_code_required' => true,'phone' =>$user->phone]);
        }

        if ($user && $user->ban_status == 'permanent') {
            return response()->json([
                    'status' => false,
                    'data' => null,
                    'message' => trans('auth.ban_permanent')]
                , 401);
        }

        if ($user && $user->ban_status == 'temporary' && !$user->ban_to?->isToday()) {
            return response()->json([
                    'status' => false,
                    'data' => null,
                    'message' => trans('auth.ban_temporary', ['ban_from' => $user->ban_from, 'ban_to' => $user->ban_to])]
                , 401);
        }

        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.failed')], 401);
        }
        $user = Auth::user();
        if ($user->ban_to?->isToday()) {
            $user->update(['ban_to' => null, 'ban_from' => null, 'ban_status' => 'active']);
        }
        return $this->makeLogin($request, $user, false);
    }

    public function otpLogin(OTPLoginRequest $request)
    {
        $user = User::whereIn('user_type', ['admin', 'superadmin'])->where(['login_code' => $request->code, 'reset_token' => $request->_token])->first();

        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.failed')], 401);
        }
        $user->update(['reset_token' => null, 'login_code' => null]);
        Auth::login($user);
        return $this->makeLogin($request, $user);
    }

    private function makeLogin($request, $user, $login_code_required = true)
    {
        $user->devices()->where('device_token', "<>", $request->device_token)->delete();
        // $user->tokens()->delete();
        // \Config::set('sanctum.expiration',setting('expiration_ttl') ?? (1*(60*24*365)));
        $token = $user->createToken('RaseedJakDashboard')->plainTextToken;
        if ($request->only(['device_token', 'device_type'])) {
            $user->devices()->firstOrCreate($request->only(['device_token', 'device_type']));
        }
        data_set($user, 'token', $token);
        return UserResource::make($user)->additional(['status' => true, 'message' => trans('auth.success_login', ['user' => $user->login_id]), 'login_code_required' => $login_code_required]);
    }

    public function resendCode(ResendCodeRequest $request)
    {
        $user = User::firstWhere('reset_token', $request->_token);
        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }
        try {
            if ($request->code_type == 'reset_code') {
                $code = $this->generateCode($request, $user, 'reset_code');
                $user->update(['reset_code' => $code]);
                return response()->json(['status' => true, 'data' => ['_token' => $user->reset_token], 'message' => trans('dashboard.general.success_send'), 'dev_message' => $code]);
            } elseif ($request->code_type == 'verified_code') {
                $code = $this->generateCode($request, $user, 'verified_code');
                $user->update(['verified_code' => $code, 'is_active' => false]);
                return response()->json(['status' => true, 'data' => ['_token' => $user->reset_token], 'message' => trans('dashboard.general.success_send'), 'dev_message' => $code]);
            } else {
                $code = $this->generateCode($request, $user, 'verified_code');
                $user->update(['verified_code' => $code, 'is_active' => false]);
                return response()->json(['status' => true, 'data' => ['_token' => $user->reset_token], 'message' => trans('dashboard.general.success_send'), 'dev_message' => $code]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('dashboard.general.fail_send')], 422);
        }
    }

    public function sendCode(SendCodeRequest $request)
    {
        $user = User::firstWhere($request->send_type, $request->username);
        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }

        if ($user->ban_status !== 'active') {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.user_is_banned')], 422);
        }
        try {
            $reset_token = generate_unique_code(User::class, 'reset_token', 100);
            if ($user->phone_verified_at || $user->email_verified_at) {
                $code = $this->generateCode($request, $user, 'reset_code');
                $user->update(['reset_code' => $code, 'reset_token' => $reset_token]);
                return response()->json(['status' => true, 'data' => ['_token' => $user->reset_token], 'message' => trans('dashboard.general.success_send'), 'dev_message' => $code]);
            } else {
                $code = $this->generateCode($request, $user, 'verified_code');
                $user->update(['verified_code' => $code, 'is_active' => false, 'reset_token' => $reset_token]);
                return response()->json(['status' => true, 'data' => ['_token' => $user->reset_token], 'message' => trans('dashboard.general.success_send'), 'dev_message' => $code]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('dashboard.general.fail_send')], 422);
        }
    }

    public function logout(LogoutRequest $request)
    {
        if (auth()->check()) {
            $user = Auth::user();
            $device = Device::where(['user_id' => $user->id, 'device_token' => $request->device_token, 'device_type' => $request->device_type])->first();
            if ($device) {
                $device->delete();
            }
            $user->currentAccessToken()->delete();
            return response()->json(['status' => true, 'data' => null, 'message' => trans('auth.logout_waiting_u_another_time')]);
        }
    }

    private function generateCode($request, $user, $col)
    {
        $code = 1111;
        if ($request['send_type'] == 'phone') {
            $code = generate_unique_code(User::class, $col, 4, 'numbers');
            $message = trans("auth.{$col}_is", ['code' => $code]);
            //   $response = send_sms($user->phone, $message);
        } elseif ($request['send_type'] == 'email') {
            $code = generate_unique_code(User::class, $col, 4, 'numbers');
            $message = trans("auth.{$col}_is", ['code' => $code]);
            // send email
        }
        // ExpireCodeJob::dispatch($user, $col)->delay((int)setting('rasidpay_verificatoin_code') ?? 1);
        return $code;
    }

    private function getCredentials(Request $request)
    {
        // $username = $request->username;
        $credentials = [];
        // switch ($username) {
        //     case filter_var($username, FILTER_VALIDATE_EMAIL):
        //         $username = 'email';
        //         break;
        //     case is_numeric($username) && strlen($username) > 6:
        //         $username = 'phone';
        //         break;
        //     default:
        //         $username = 'login_id';
        //         break;
        // }

        $username = 'login_id';
        $credentials[$username] = $request->username;
        $credentials['password'] = $request->password;
        // $credentials['is_blacklist'] = 1;
        return $credentials;
    }
}
