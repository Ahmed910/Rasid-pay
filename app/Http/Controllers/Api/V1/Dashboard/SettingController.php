<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\Settings\CreateSetting;
use App\Http\Requests\V1\Dashboard\Settings\SettingRequest;
use App\Http\Resources\Dashboard\SettingResource;
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
        $path =  "images/setting";

        foreach ($request->validated()['settings'] as $key => $value) {

            foreach (config('translatable.locales') as $locale) {
                if (isset($value[$locale]) && $value[$locale] instanceof UploadedFile) {
                    $value[$locale] =  $value[$locale]->storePublicly($path, "public");
                }
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

    /**
     * For Developers
     */
    public function createSetting(CreateSetting $data)
    {
        $path =  "images/setting";

        foreach ($data['settings'] as $setting) {
            foreach (config('translatable.locales') as $locale) {
                if (isset($setting['value'][$locale]) && $setting['value'][$locale] instanceof UploadedFile) {
                    $setting['value'][$locale] =  $setting['value'][$locale]->storePublicly($path, "public");
                }
            }


            Setting::where("dashboard", Setting::ERP)
                ->updateOrCreate(
                    ['key'   => $setting['key']],
                    ['value' =>  $setting['value'], 'input_type' => $setting['input_type']],
                );
        }

        return [
            'data'    => "",
            'message' => 'success',
            'status'  => true
        ];
    }
}
