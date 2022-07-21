<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\SettingResource;
use App\Models\Setting;

class SettingController extends Controller
{
    public function socialContact()
    {
        $social_settings = ["rasid_social_fb_link", "rasid_social_linkedin_link", "rasid_social_instagram_link", "rasid_social_twitter_link", "rasid_social_whatsapp_link", "rasid_website_link"];
        $social = Setting::select('value->en as name', 'key')->whereIn('key', $social_settings)->get();
        return SettingResource::collection($social)->additional([
            'status' => true,
            'message' => ''
        ]);
    }
}
