<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\{
    WalletBinRequest,
    Profile\UpdateProfileRequest,
    Profile\UpdatePasswordRequest
};
use App\Http\Resources\Api\V1\Mobile\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return UserResource::make(auth()->user()->load('citizen'))->additional(['status' => true, 'message' => '']);
    }

    public function store(UpdateProfileRequest $request)
    {
        $citizen = auth()->user();
        $old_phone = $citizen->phone;
        $citizen->fill($request->validated())->save();
        $citizen->citizen()->update($request->only(['lat', 'lng', 'location']));
        $message = trans('dashboard.general.success_update');
        if ($old_phone != $citizen->phone) {
            #logout_then_send_sms
            $code = $this->sendSmsToCitizen($citizen->phone);
            $citizen->update([
                'verified_phone_at' => null,
                'verified_code' => $code
            ]);

            $citizen->phones()->create([
            'new_phone'=>$citizen->phone,
            'old_phone'=>$old_phone,
            'verified_at' => now(),
            ]);
            $message = trans('auth.success_update_verify_phone');
        }
        return UserResource::make($citizen->load('citizen'))->additional(['status' => true, 'message' => $message]);
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
            'message' => auth()->user()->is_notification_enabled == 1 ? trans('auth.success_activate_notifcation') : trans('auth.success_unactivate_notifcation'),
            'data' => null,
        ]);
    }
     public function archiveCitizen()
    {
        auth()->user()->delete() ;
        return response()->json([
            'status' => true,
            'message' => trans('auth.success_archive'),
            'data' => null,
        ]);
    }

}
