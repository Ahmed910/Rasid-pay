<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Resources\Api\V1\Mobile\SettingResource;

class SettingController extends Controller
{
    public function socialContact(){
        $social_settings =["rasid_social_fb_link","rasid_social_linkedin_link","rasid_social_instagram_link","rasid_social_twitter_link","rasid_social_whatsapp_link","rasid_website_link"];
       $social= Setting::selectRaw("json_unquote(json_extract(`value`, '$.en')) as `name`, `key` as `key`")
       ->whereIn("key",$social_settings)->get();
        return SettingResource::collection($social)->additional([
            'status'=>true,
            'message'=>''
        ]);
    }
}
