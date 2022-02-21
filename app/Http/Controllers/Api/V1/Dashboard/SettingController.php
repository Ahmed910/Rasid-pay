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
        $defaultLocale = "en";
        $restLocales   = array_filter(config('translatable.locales'), fn ($locale) => $locale == $defaultLocale ?: $locale);
        $path          =  "images/setting";

        foreach ($request->validated()['settings'] as $key => $value) {

            foreach ($restLocales as $locale) {
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
}
