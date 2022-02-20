<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\Auth\{LoginRequest, SendCodeRequest, LogoutRequest, ResetPasswordRequest};
use App\Http\Resources\Dashboard\UserResource;
use App\Jobs\ExpireCodeJob;
use App\Models\{Device, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['only' => ['logout']]);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($this->getCredentials($request))) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.failed')], 401);
        }
        $user = Auth::user();
        $user->devices()->where('device_token',"<>",$request->device_token)->delete();
        $user->tokens()->delete();
        \Config::set('sanctum.expiration',setting('expiration_ttl') ?? 1);
        $token =  $user->createToken('RaseedJakDashboard')->plainTextToken;
        $user->devices()->firstOrCreate($request->only(['device_token', 'device_type']));
        data_set($user, 'token', $token);
        return UserResource::make($user)->additional(['status' => true, 'message' => trans('auth.success_login', ['user' => $user->phone])]);
    }

    public function sendCode(SendCodeRequest $request)
    {
        $user = User::firstWhere($request->send_type, $request->username);
        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.phone_not_exists')], 422);
        }
        try {
            if ($user->phone_verified_at || $user->email_verified_at) {
                $code = $this->generateCode($request, $user,'reset_code');
                $user->update(['reset_code' => $code]);
                return response()->json(['status' => true, 'data' => null, 'message' => trans('dashboard.general.success_send'), 'dev_message' => $code]);
            } else {
                $code = $this->generateCode($request, $user,'verified_code');  
                $user->update(['verified_code' => $code, 'is_active' => 0]);
                return response()->json(['status' => true, 'data' => null, 'message' => trans('dashboard.general.success_send'), 'dev_message' => $code]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.fail_send')], 422);
        }
    }

    protected function getCredentials(Request $request)
    {
        $username = $request->username;
        $credentials = [];
        switch ($username) {
            case filter_var($username, FILTER_VALIDATE_EMAIL):
                $username = 'email';
                break;
            case is_numeric($username):
                $username = 'phone';
                break;
            default:
                $username = 'email';
                break;
        }
        $credentials[$username] = $request->username;
        $credentials['password'] = $request->password;
        // $credentials['is_active'] = 1;
        return $credentials;
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::firstWhere(['phone' => $request->phone]);

        $user_data = [];
        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.phone_not_true_or_account_deactive')], 422);
        } elseif (!$user->phone_verified_at && $user->verified_code == $request->code) {
            $user_data += ['password' => $request->password, 'verified_code' => null, 'is_active' => true, 'phone_verified_at' => now()];
        } elseif ($user->phone_verified_at && $user->reset_code == $request->code) {
            $user_data += ['password' => $request->password, 'reset_code' => null];
        }
        $user->update($user_data);

        return response()->json(['status' => true, 'data' => null, 'message' => trans('auth.success_change_password')]);
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
        if ($request->send_type == 'phone' && setting('use_sms_service') == 'enable') {
            $code = generate_unique_code('\\App\\Models\\User', $col, 4);
            $message = trans("auth.{$col}_is", ['code' => $code]);
            //   $response = send_sms($user->phone, $message);
        }elseif ($request->send_type == 'email' && setting('use_email_service') == 'enable') {
            // send email
        }
        ExpireCodeJob::dispatch($user, $col)->delay((int)setting('code_ttl'));
        return $code;
    }
}
