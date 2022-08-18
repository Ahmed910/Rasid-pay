<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Settings\CreateSetting;
use App\Http\Requests\Dashboard\Settings\SettingRequest;
use App\Http\Resources\Api\Dashboard\SettingResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::select('key', 'value', 'input_type', 'is_single')
            ->oldest('is_single')
            ->paginate((int)($request->per_page ?? 10));

        return SettingResource::collection($settings)
            ->additional([
                'message' => 'success',
                'status' => true
            ]);
    }

    public function store(SettingRequest $request)
    {
        $path =  "images/setting";
        Cache::forget('settings');

        foreach ($request->validated()['settings'] as $key => $value) {

            foreach (config('translatable.locales') as $locale) {
                if (isset($value[$locale]) && $value[$locale] instanceof UploadedFile) {
                    $value[$locale] =  $value[$locale]->storePublicly($path, "public");
                }
            }


            Setting::where("key", $key)->update([
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
        Cache::forget('settings');

        foreach ($data['settings'] as $setting) {
            foreach (config('translatable.locales') as $locale) {
                if (isset($setting['value'][$locale]) && $setting['value'][$locale] instanceof UploadedFile) {
                    $setting['value'][$locale] =  $setting['value'][$locale]->storePublicly($path, "public");
                }
            }

            Setting::updateOrCreate(
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
