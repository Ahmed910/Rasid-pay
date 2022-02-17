<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\SettingResource;
use App\Http\Requests\V1\Dashboard\SettingRequest;
use Illuminate\Http\UploadedFile;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::where("dashboard", Setting::ERP)->select('key', 'value', 'input_type')
            ->latest()->paginate((int)($request->perPage ?? 10));

        return SettingResource::collection($settings)
            ->additional([
                'message' => 'success',
                'status' => true
            ]);
    }

    public function store(SettingRequest $request)
    {
        foreach ($request->validated()['settings'] as $key => $value) {

            if ($value['en'] instanceof UploadedFile) {
                $value['en'] =  $value['en']->storePublicly("images/setting", "public");
            }

            if ($value['ar'] instanceof UploadedFile) {
                $value['ar'] =  $value['ar']->storePublicly("images/setting", "public");
            }

            Setting::where("dashboard", Setting::ERP)
                ->where("key", $key)->update([
                    "value" =>  $value,
                ]);
        }

        return [
            'data'    => "",
            'message' => 'success',
            'status'  => true
        ];
    }
}
