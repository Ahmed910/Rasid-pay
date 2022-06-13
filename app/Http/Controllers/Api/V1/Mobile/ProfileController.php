<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\{
    WalletBinRequest,
    UpdateProfileRequest,
    Profile\UpdatePasswordRequest
};
use App\Http\Resources\Mobile\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return UserResource::make(auth()->user())->additional(['status' => true, 'message' => '']);
    }

    public function store(UpdateProfileRequest $request)
    {
        $citizen = auth()->user();
        $old_phone = $citizen->phone;
        $citizen->fill($request->validated())->save();
        $citizen->citizen()->update($request->only(['lat', 'lng', 'location']));
        $message = trans('auth.success_update');
        if ($old_phone != $citizen->phone) {
            #logout_then_send_sms
            $code = $this->sendSmsToCitizen($citizen->phone);
            $citizen->update([
                'verified_phone_at' => null,
                'verified_code' => $code
            ]);
            $message = trans('auth.success_update_verify_phone');
        }
        return UserResource::make($citizen)->additional(['status' => true, 'message' => $message]);
    }

    private function sendSmsToCitizen($phone)
    {
        $code = 1111;
        if (setting('use_sms_service') == 'enable') {
           $code = generate_unique_code(User::class, 'phone', 4, 'numbers');
        }
        return $code;
    }

    /**
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        auth()->user()->update([
            'password' => $request->new_password
        ]);
        return response()->json([
            'status' => true,
            'message' => trans('auth.success_update_password'),
            'data' => null,
        ]);
    }

    /**
     * @param ActivateNotificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
     public function activateNotification(Request $request)
    {
        auth()->user()->update(['is_notification_enabled' => !auth()->user()->is_notification_enabled]);
        return response()->json([
            'status' => true,
            'message' => trans('auth.success_activate_notifcation'),
            'data' => null,
        ]);
    }

    public function setWalletBin(WalletBinRequest $request)
    {
        auth()->user()->citizenWallet()?->update(['wallet_bin'=>$request->wallet_bin,'number_of_tries'=> 0]);
        return response()->json(['data'=>null,'status'=>true,'message'=>trans('mobile.messages.wallet_bin_has_been_updated')]);
    }
}
