<?php

namespace App\Http\Controllers\Blade\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\CheckSmsCodeLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Auth\LoginRequest;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(LoginRequest $request)
    {
        if (!$request->ajax()) {
            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if (
                method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)
            ) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', time());
                }

                return $this->sendLoginResponse($request);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->has('username') ? [$this->username() => $request->username, 'password' => $request->password] : $request->only($this->username(), 'password');
        return $credentials;
    }

    public function username()
    {
        // $username = request()->username;
        // switch ($username) {
        //   case filter_var($username, FILTER_VALIDATE_EMAIL):
        //       $username = 'email';
        //     break;
        //   case is_numeric($username):
        //         $username = 'phone';
        //         break;
        //   default:
        //        $username = 'login_id';
        //     break;
        // }
        // return $username;
        return 'login_id';
    }

    // protected function validateLogin(LoginRequest $request)
    // {
    //    $username = $this->username() == 'login_id' ? ['username' => 'required|numeric'] : ['username' => 'required|email'];
    //     $request->validate([
    //        'password' => 'required|string'
    //     ]+$username);
    // }
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        $user  = auth()->user();
        if (($user->user_type == 'superadmin' && !$user->permissions()->exists()) || ($user->permissions()->exists() && $user->user_type == 'admin')) {

            $this->redirectTo = 'dashboard/';
            return $this->redirectTo;
        }

       return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->is_login_code && is_null($user->login_code)) {

            $code = $this->generateCode(['send_type' => 'phone'], $user, 'login_code');
            $reset_token = generate_unique_code(User::class, 'reset_token', 100);
            $user->update(['login_code' => $code, 'reset_token' => $reset_token]);
            auth()->logout();

            return redirect()->route('dashboard.check_sms_code_form_login',['token'=>$reset_token]);
        }
        /*else{

            $user->update(['login_code'=>null,'reset_token'=>null]);
            auth()->logout();
            return redirect()->route('dashboard.login');
        }*/
    }
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view("dashboard.auth.login");
    }

    public function logout(Request $request)
    {

        if (auth()->check() && in_array(auth()->user()->user_type, ['superadmin', 'admin'])) {
            auth()->user()->update(['login_code'=>null,'reset_token'=>null]);
            $this->guard()->logout();
            $request->session()->invalidate();
            session()->flash('success', trans('auth.logout_waiting_u_another_time'));
            return redirect()->route('dashboard.login');
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
        // ExpireCodeJob::dispatch($user, $col)->delay((int)setting('erp_code_ttl') ?? 1);
        return $code;
    }

    public function showCodeCheckForm($token)
    {

        $user = User::whereIn('user_type',['admin','superadmin'])->firstWhere('reset_token',$token);
        if (!$user) {
            return back()->withFalse(trans('auth.account_not_exists'));
        }
        $phone =  '(+996)' . str_repeat("*", strlen($user->phone)-4) . substr($user->phone, -3);
        return view('dashboard.auth.verify_code_login',['reset_token' => $user->reset_token, 'phone' => $phone]);
    }

    public function checkSmsCode(CheckSmsCodeLoginRequest $request)
    {

        $user = User::whereIn('user_type',['admin','superadmin'])->where(['reset_token' => $request->reset_token, 'login_code' => $request->login_code])->first();

        if (!$user) {
            return back()->withInput()->withFalse(trans('auth.account_not_exists'));
        }
        auth()->login($user);

        return redirect('/dashboard');
      //  return redirect()->route('dashboard.get_phone_password_reset',$user->reset_token)->withTrue(trans('auth.success_code_plz_add_new_password'));

    }


}
