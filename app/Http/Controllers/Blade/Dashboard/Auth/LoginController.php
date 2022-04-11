<?php

namespace App\Http\Controllers\Blade\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Auth\LoginRequest;

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

    public function login(LoginRequest $request)
    {
<<<<<<< HEAD
        if (!$request->ajax()) {
            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
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

=======
        $username = $this->username() == 'login_id' ? ['username' => 'required|numeric'] : ['username' => 'required|email'];
        $request->validate([
            'password' => 'required|string'
        ] + $username);
>>>>>>> 86c099fca8d9dfa77355d7b73caafb02550ceef0
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
        if ((auth()->user()->user_type == 'superadmin' && !auth()->user()->permissions()->exists()) || (auth()->user()->permissions()->exists() && auth()->user()->user_type == 'admin')) {
            $this->redirectTo = 'dashboard/';
            return $this->redirectTo;
        }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
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
            $this->guard()->logout();
            $request->session()->invalidate();
            session()->flash('info', trans('auth.logout_waiting_u_another_time'));
            return redirect()->route('dashboard.login');
        }
    }
}
