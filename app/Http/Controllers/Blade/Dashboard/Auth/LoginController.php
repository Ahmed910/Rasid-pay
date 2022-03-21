<?php

namespace App\Http\Controllers\Blade\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    protected function credentials(Request $request)
    {
        $credentials = $request->has('username') ? [$this->username() => $request->username, 'password' => $request->password] : $request->only($this->username(), 'password');
        $credentials['is_active'] = 1;
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

    protected function validateLogin(Request $request)
    {
       $username = $this->username() == 'login_id' ? ['username' => 'required|numeric'] : ['username' => 'required|email'];
        $request->validate([
           'password' => 'required|string'
        ]+$username);
    }
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if ((auth()->user()->user_type == 'superadmin' && !auth()->user()->permissions()->exists()) || (auth()->user()->permissions()->exists() && auth()->user()->user_type == 'admin')) {
              $this->redirectTo='dashboard/';
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
        if (auth()->check() && in_array(auth()->user()->user_type,['superadmin','admin'])) {
            $this->guard()->logout();
            $request->session()->invalidate();
            session()->flash('info', trans('auth.logout_waiting_u_another_time'));
            return redirect()->route('dashboard.login');
        }
    }
}
