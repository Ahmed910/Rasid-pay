<?php

namespace App\Http\Controllers\Blade\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\Dashboard\Auth\{CheckSmsCodeRequest, ResetPasswordRequest, ResetEmailPasswordRequest};
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;

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
    // protected $redirectTo = RouteServiceProvider::HOME;

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
        dd($request);
        $user = User::whereIn('user_type',['admin','superadmin'])->where(['reset_token' => $request->reset_token, 'reset_code' => $request->reset_code])->first();
        if (!$user) {
            return back()->withInput()->withFalse(trans('auth.account_not_exists'));
        }
        return redirect()->route('dashboard.get_phone_password_reset',$user->reset_token)->withTrue(trans('auth.success_code_plz_add_new_password'));

    }

    public function redirectPath()
    {
        if ((auth()->user()->user_type == 'superadmin' && !auth()->user()->permissions()->exists()) || (auth()->user()->permissions()->exists() && auth()->user()->user_type == 'admin')) {
              $this->redirectTo = 'dashboard/login';
              return $this->redirectTo;
          }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : 'dashboard/login';
    }

    public function showResetPhoneForm($reset_token)
    {
        $user = User::whereIn('user_type',['admin','superadmin'])->firstWhere('reset_token',$reset_token);
        if (!$user) {
            return back()->withFalse(trans('auth.account_not_exists'));
        }
        return view('dashboard.auth.new_phone_password',compact('reset_token'));
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

    public function showResetEmailForm(Request $request, $token = null)
    {
        return view('dashboard.auth.new_email_password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(ResetEmailPasswordRequest $request)
    {
        // $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

}
