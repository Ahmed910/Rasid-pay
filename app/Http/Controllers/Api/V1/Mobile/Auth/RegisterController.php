<?php

namespace App\Http\Controllers\Api\V1\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Auth\CheckVerificationCodeRequest;
use App\Http\Requests\V1\Mobile\Auth\CompleteRegisterRequest;
use App\Http\Requests\V1\Mobile\Auth\RegisterRequest;
use App\Http\Resources\Mobile\UserResource;
use App\Models\{User, CitizenWallet};

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, User $user)
    {
        $data = $request->validated();
        $userData = ['user_type' => 'citizen', 'fullname' => 'citizen_' . $data['phone']];

        $user->fill($data + $userData)->save();
        // Generate Wallet Number & QR
        $wallet_number = generate_unique_code(CitizenWallet::class, 'wallet_number', 11, 'numbers');
        $user->citizenWallet()->create(['wallet_number' => $wallet_number]);
        $user->citizen()->create();
        $user->citizenCards()->create();
        //TODO: api service for elm to verify account
        //TODO: api service for send sms to phone number
        $code = 111111;
        if (setting('use_sms_service') == 'enable') {
            $code = generate_unique_code(User::class, 'phone', 4, 'numbers');
        }
        $user->update(['verified_code' => $code, 'is_active' => false]);

        return response()->json([
            'status' => true,
            'data'   => UserResource::make($user),
            'message' => trans('auth.success_signup')
        ]);
    }

    public function checkVerificationCode(CheckVerificationCodeRequest $request)
    {
        $userData =  [
            $request->key_name  => null,
            'is_active'         => true
        ];

        if ($request->key_name == 'verified_code') {
            $userData['phone_verified_at'] = now();
        }

        $user = User::firstWhere([
            'phone' => $request->phone,
            $request->key_name => $request->code,
            'user_type' => 'citizen'
        ]);

        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }

        $user->update($userData);
        $token =  $user->createToken('RasidBackApp')->plainTextToken;

        data_set($user, 'token', $token);

        return UserResource::make($user)->additional([
            'status' => true,
            'message' => trans('auth.success_login', ['user' => $user->phone]),
        ]);
    }

    public function completeRegister(CompleteRegisterRequest $request)
    {
        $user = User::firstWhere([
            'phone' => $request->phone,
            'user_type' => 'citizen'
        ]);

        $user->fill($request->password)->save();
        $token =  $user->createToken('RasidBackApp')->plainTextToken;

        data_set($user, 'token', $token);

        return UserResource::make($user)->additional([
            'status' => true,
            'message' => trans('auth.success_login',),
        ]);
    }
}
