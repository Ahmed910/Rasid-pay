<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\{
    Profile\UpdateProfileRequest,
    Profile\UpdatePasswordRequest
};
use App\Http\Resources\Api\Mobile\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $citizen_data = $request->validated();
        if ($request->need_to_delete_image && $citizen->images()->exists()) {
            $path = Str::replace("/storage/", "", $citizen->images()->first()?->media);

            Storage::disk('public')->delete($path);
            $citizen->images()->forceDelete();
            $citizen_data += ['updated_at' => now()];
        }
        $citizen->fill($citizen_data)->save();
        $citizen->citizen()->update($request->only(['lat', 'lng', 'location']));
        $message = trans('dashboard.general.success_update');
        if ($old_phone != $citizen->phone || !$citizen->phone_verified_at) {
            #logout_then_send_sms
            $code = $this->sendSmsToCitizen($citizen->phone);
            $citizen->phones()->create([
                'new_phone' => $citizen->phone,
                'old_phone' => $old_phone,
                'old_verified_at' => $citizen->phone_verified_at,
            ]);
            $citizen->update([
                'phone_verified_at' => null,
                'verified_code' => $code
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
        auth()->user()->delete();
        return response()->json([
            'status' => true,
            'message' => trans('auth.success_archive'),
            'data' => null,
        ]);
    }
}
