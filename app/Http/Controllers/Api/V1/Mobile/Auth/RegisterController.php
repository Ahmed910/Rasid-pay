<?php

namespace App\Http\Controllers\Api\V1\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Auth\{CompleteRegisterRequest, RegisterRequest, VerifyPhoneCodeRequest};
use App\Http\Resources\Api\V1\Mobile\UserResource;
use App\Models\{CitizenPackage, CitizenWallet, Transaction, User};
use App\Models\Transfer;
use App\Notifications\GeneralNotification;


class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $userData = ['user_type' => 'citizen', 'fullname' => 'citizen_' . $data['identity_number']];
        $user = User::firstOrNew([
            'identity_number' => $request->identity_number,
            'user_type' => 'citizen'
        ]);
        if (!$user->phone) {
            $user = User::firstOrNew([
                'phone' => $request->phone,
                'user_type' => 'citizen'
            ]);
        }
        $response = LoginController::checkIsUserValid($user);
        if ($response) {
            return response()->json($response['response'], $response['status_code']);
        }
        $user->fill($data + $userData)->save();
        //TODO: api service for send sms to phone number
        //TODO: api service for elm to verify account
        $code = 1111;
        if (setting('use_sms_service') == 'enable') {
            $code = generate_unique_code(User::class, 'phone', 4, 'numbers');
        }
        $user->update(['verified_code' => $code, 'is_active' => false]);
        $user->mask_phone = '***********' . substr($user->phone, -3);

        return UserResource::make($user)->additional([
            'status' => true,
            'message' => trans('auth.verify_phone')
        ]);
    }

    public function checkUserCode(VerifyPhoneCodeRequest $request)
    {
        $user = User::firstWhere([
            'identity_number' => $request->identity_number,
            $request->key_name => $request->code,
            'user_type' => 'citizen'
        ]);

        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }

        return response()->json([
            'status' => true,
            'data' => null,
            'message' => trans('auth.success_verify_phone', ['user' => '***********' . substr($user->phone, -3)]),
        ]);
    }

    public function verifyPhoneCode(VerifyPhoneCodeRequest $request)
    {
        $userData = [
            $request->key_name => null,
            'is_active' => true
        ];

        if ($request->key_name == 'verified_code') {
            $userData['phone_verified_at'] = now();
        }

        $user = User::firstWhere([
            'identity_number' => $request->identity_number,
            $request->key_name => $request->code,
            'user_type' => 'citizen'
        ]);

        if (!$user) {
            return response()->json(['status' => false, 'data' => null, 'message' => trans('auth.account_not_exists')], 422);
        }

        $user->update($userData);

        return UserResource::make($user)->additional([
            'status' => true,
            'message' => trans('auth.success_verify_phone', ['user' => '**********' . substr($user->phone, -3)]),
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
        // Generate Wallet Number & QR
        $wallet_number = generate_unique_code(CitizenWallet::class, 'wallet_number', 11, 'numbers');
        $user->citizenWallet()->create(['wallet_number' => $wallet_number, 'last_updated_at' => now()]);
        $citizen_table = ['user_id' => $user->id];
        $package_data = [
            'citizen_id' => $user->id,
            'package_type' => CitizenPackage::BASIC,
            'package_price' => setting('rasidpay_cards_basic_price'),
            'start_at' => now(),
            'end_at' => now()->addMonths(12)
        ];
        $citizenPackage = $user->citizenPackages()->create($package_data);
        $citizen_table += [
            'citizen_package_id' => $citizenPackage->id
        ];
        $user->citizen()->create($citizen_table);
        $this->checkTransaction($user);

        return UserResource::make($user)->additional([
            'status' => true,
            'message' => trans('auth.success_verify_phone_make_login'),
        ]);
    }

    public function checkTransaction($user)
    {

        // check transaction
        $transfers = Transfer::where(['phone' => $user->phone, 'transfer_status' => Transfer::PENDING])->get();
        if ($transfers) {
            // update transfer_status ,transaction_status
            $transfers->each(function ($item) {
                $item->update(['transfer_status' => Transfer::TRANSFERRED]);
                $item->transaction->update(['trans_status' => Transaction::SUCCESS]);
            });

            // check  main_amount & cashback_amount to wallet
            $citizen_wallet = CitizenWallet::with('citizen')->where('citizen_id', $user->id)->firstOrFail();
            $main_amount =  $transfers->sum('main_amount');
            $cashback_amount =  $transfers->sum('cashback_amount');

            if ($citizen_wallet) {
                $citizen_wallet->update(["cash_back" => \DB::raw('cash_back + ' . $cashback_amount), 'main_balance' => \DB::raw('main_balance + ' . $main_amount)]);
            }

            //send notification
            $notify_data = [
                'title' => trans('mobile.notifications.has_transfer.title'),
                'body' => trans(
                    'mobile.notifications.has_transfer.body',
                    ['transfer_method_value' => $user->phone]
                ),
            ];

            $user->notify(new GeneralNotification($notify_data, ['database']));
        }
    }
}
