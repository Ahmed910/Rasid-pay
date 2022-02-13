<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\Auth\LoginRequest;
use App\Http\Resources\Dashboard\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{    
    public function login(LoginRequest $request)
    {
        // dd($this->getCredentials($request));
        if (!$token = Auth::attempt($this->getCredentials($request))) {
            return response()->json(['status' => false, 'data' => null , 'message' => trans('auth.failed')],Response::HTTP_UNAUTHORIZED);
        } 
        $user = Auth::user(); 
        $token =  $user->createToken('RaseedJakDashboard')->plainTextToken;
        $user->devices()->firstOrCreate($request->only(['device_token','device_type']));

        data_set($user,'token' , $token);
        return UserProfileResource::make($user)->additional(['status' => false , 'message' => trans('auth.success_login')]);
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
