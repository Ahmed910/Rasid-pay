<?php

namespace App\Http\Controllers\Blade\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Requests\Dashboard\Auth\SendTokenRequest;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    public function showLinkRequestForm()
    {
        return view('dashboard.auth.reset');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(SendTokenRequest $request)
    {
        if ($request->send_type == 'phone') {
            return $this->sendSmsCode($request);
        }
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        // dd($request);
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function sendResetLinkResponse($request, $response)
    {
        return back()->withTrue(trans($response));
    }


    private function sendSmsCode($request)
    {
        $user = User::firstWhere($request->send_type, $request[$request->send_type]);
        if (!$user) {
            return back()->withFalse(trans('auth.account_not_exists'));
        }
        $reset_token = generate_unique_code(User::class, 'reset_token', 100);
        $code = $this->generateCode($request, $user,'reset_code');
        $user->update(['reset_code' => $code, 'reset_token' => $reset_token]);
        return redirect()->route('dashboard.check_sms_code_form',$reset_token);
    }

    private function generateCode($request, $user, $col)
    {
        $code = 1111;
        // if ($request['send_type'] == 'phone') {
        //     $code = generate_unique_code(User::class, $col, 4, 'numbers');
        //     $message = trans("auth.{$col}_is", ['code' => $code]);
        //     //   $response = send_sms($user->phone, $message);
        // }elseif ($request['send_type'] == 'email') {
        //     $code = generate_unique_code(User::class, $col, 4, 'numbers');
        //     $message = trans("auth.{$col}_is", ['code' => $code]);
        //     // send email
        // }
        // ExpireCodeJob::dispatch($user, $col)->delay((int)setting('erp_code_ttl') ?? 1);
        return $code;
    }
}
