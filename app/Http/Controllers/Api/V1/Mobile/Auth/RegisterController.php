<?php

namespace App\Http\Controllers\Api\V1\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Auth\CheckVerificationCodeRequest;
use App\Http\Requests\V1\Mobile\Auth\CompleteRegisterRequest;
use App\Http\Requests\V1\Mobile\Auth\RegisterRequest;
use App\Http\Resources\Mobile\UserResource;
use App\Models\{CitizenPackage, User, CitizenWallet, Package\Package};

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
        $package = Package::where(['is_active' => 1, 'is_default' => 1])->first();
        if ($package) {
            $package_data = [
                'package_id' => $package->id,
                'package_price' => $package->price,
                'package_discount' => $package->discount,
                'start_at' => now(),
                'end_at' => now()->addMonths($package->duration)
            ];

            if ($package->has_promo) {
                $package_data += [
                    'promo_code' => generate_unique_code(CitizenPackage::class, 'promo_discount'),
                    'promo_discount' => $package->promo_discount,
                    'remaining_usage' => $package->number_of_used
                ];
            }
            
            $citizenPackage = $user->citizenPackages()->create($package_data);

            $user->citizen()->create([
                'citizen_package_id' => $citizenPackage->id
            ]);
        }
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
            'message' => trans('auth.verify_phone')
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

        return UserResource::make($user)->additional([
            'status' => true,
            'message' => trans('auth.success_verify_phone', ['user' => $user->phone]),
        ]);
    }

    public function completeRegister(CompleteRegisterRequest $request)
    {
        $user = User::firstWhere([
            'identity_number' => $request->identity_number,
            'user_type' => 'citizen'
        ]);

        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }

        if ($user->verified_code) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.verify_phone_first')], 422);
        }

        $user->fill(['password' => $request->password, 'register_status' => 'completed'])->save();
        $token =  $user->createToken('RasidBackApp')->plainTextToken;

        data_set($user, 'token', $token);

        return UserResource::make($user)->additional([
            'status' => true,
            'message' => trans('auth.success_signup',),
        ]);
    }
}
