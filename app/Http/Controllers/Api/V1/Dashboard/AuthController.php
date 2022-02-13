<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\Auth\{LoginRequest,SendCodeRequest};
use App\Http\Resources\Dashboard\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{    
    public function login(LoginRequest $request)
    {
        if (!$token = Auth::attempt($this->getCredentials($request))) {
            return response()->json(['status' => false, 'data' => null , 'message' => trans('auth.failed')],Response::HTTP_UNAUTHORIZED);
        } 
        $user = Auth::user(); 
        $token =  $user->createToken('RaseedJakDashboard')->plainTextToken;
        $user->devices()->firstOrCreate($request->only(['device_token','device_type']));
        data_set($user,'token' , $token);
        return UserResource::make($user)->additional(['status' => true , 'message' => trans('auth.success_login')]);
    }

    public function sendCode(SendCodeRequest $request)
      {
        $user = User::where('phone',$request->phone)->first();
        if (! $user) {
          return response()->json(['status' => false,'data'=> null ,'message'=> trans('auth.phone_not_exists')],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try{
          if ($user->phone_verified_at || $user->email_verified_at) {
              $code = 1111;
              if (setting('use_sms_service') == 'enable') {
                  $code = generate_unique_code('\\App\\Models\\User','reset_code', 4);
                  $message = trans('auth.reset_code_is',['code' => $code]);
                //   $response = send_sms($user->phone, $message);
              }
              $user->update(['reset_code' => $code]);
              return response()->json(['status' => true,'data'=> null ,'message'=> trans('dashboard.general.success_send'),'dev_message' => $code ]);
          }else {
              $code = 1111;
              if (setting('use_sms_service') == 'enable') {
                  $code = generate_unique_code('\\App\\Models\\User','verified_code',4);
                  $message = trans('auth.verified_code_is',['code' => $code]);
                //   $response = send_sms($user->phone, $message);
              }
              $user->update(['verified_code' => $code , 'is_active' => 0]);

              return response()->json(['status' => true,'data'=> null ,'message'=> trans('dashboard.general.success_send') ,'dev_message' => $code]);
          }
        }catch(\Exception $e){
          return response()->json(['status' => false,'data'=> null ,'message'=> trans('auth.fail_send')]);
        }

      }



    protected function getCredentials(Request $request)
    {
         $username = $request->username;
         $credentials =[];
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
}
