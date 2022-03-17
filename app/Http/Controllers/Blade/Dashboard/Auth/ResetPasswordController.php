<?php

namespace App\Http\Controllers\Blade\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\Dashboard\Auth\{CheckSmsCodeRequest, ResetPasswordRequest};
use App\Models\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showCodeCheckForm($token)
    {
        $user = User::whereIn('user_type',['admin','superadmin'])->firstWhere('reset_token',$token);
        if (!$user) {
            return back()->withFalse(trans('auth.account_not_exists'));
        }
        $phone =  '(+996)' . str_repeat("*", strlen($user->phone)-4) . substr($user->phone, -3);
        return view('dashboard.auth.verify_code',['reset_token' => $user->reset_token, 'phone' => $phone]);
    }

    public function checkSmsCode(CheckSmsCodeRequest $request)
    {
        $user = User::whereIn('user_type',['admin','superadmin'])->where(['reset_token' => $request->reset_token, 'reset_code' => $request->reset_code])->first();
        if (!$user) {
            return back()->withInput()->withFalse(trans('auth.account_not_exists'));
        }
        return redirect()->route('dashboard.get_phone_password_reset',$user->reset_token)->withTrue(trans('auth.success_code_plz_add_new_password'));

    }

    public function showPhoneResetForm($reset_token)
    {
        $user = User::whereIn('user_type',['admin','superadmin'])->firstWhere('reset_token',$reset_token);
        if (!$user) {
            return back()->withFalse(trans('auth.account_not_exists'));
        }
        return view('dashboard.auth.new_password',compact('reset_token'));
    }

    public function resetUsingPhone(ResetPasswordRequest $request, $reset_token)
    {
        $user = User::whereIn('user_type',['admin','superadmin'])->firstWhere('reset_token', $reset_token);
        if (!$user) {
            return back()->withInput()->withFalse(trans('auth.account_not_exists'));
        }
        $user->update(['password' => $request->password,'reset_token' => null, 'reset_code' => null]);
        return redirect()->route('dashboard.login')->withTrue(trans('auth.success_change_password'));
    }

}
