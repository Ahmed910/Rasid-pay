<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

if (!function_exists('convert_arabic_number')) {
    function convert_arabic_number($number)
    {
        $arabic_array = ['۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'];
        return strtr($number, $arabic_array);
    }
}

if (!function_exists('filter_mobile_number')) {
    function filter_mobile_number($mob_num)
    {
        $mob_num = convert_arabic_number($mob_num);
        $first_3_val = substr($mob_num, 0, 3);
        $first_4_val = substr($mob_num, 0, 4);
        $sixth_val = substr($mob_num, 0, 6);
        $first_val = substr($mob_num, 0, 1);
        $mob_number = 0;
        $val = 0;
        if ($sixth_val == "009665") {
            $val = null;
            $mob_number = substr($mob_num, 2, 12);
        } elseif ($sixth_val == "009660") {
            $val = 966;
            $mob_number = substr($mob_num, 6, 14);
        } elseif ($first_3_val == "+96") {
            $val = "966";
            $mob_number = substr($mob_num, 4);
        } elseif ($first_4_val == "9660") {
            $val = "966";
            $mob_number = substr($mob_num, 4);
        } elseif ($first_3_val == "966") {
            $val = null;
            $mob_number = $mob_num;
        } elseif ($first_val == "5") {
            $val = "966";
            $mob_number = $mob_num;
        } elseif ($first_3_val == "009") {
            $val = "9";
            $mob_number = substr($mob_num, 4);
        } elseif ($first_val == "0") {
            $val = "966";
            $mob_number = substr($mob_num, 1, 9);
        } else {
            $val = "966";
            $mob_number = $mob_num;
        }

        $real_mob_number = $val . $mob_number;
        return $real_mob_number;
    }
}

if (!function_exists('generate_unique_code')) {
    function generate_unique_code($model, $col = 'code', $length = 4, $letter_type = null)
    {
        $characters = '';
        switch ($letter_type) {
            case 'lower':
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                break;
            case 'upper':
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'numbers':
                $characters = '0123456789';
                break;

            default:
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
        }
        $generate_random_code = '';
        $charactersLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $generate_random_code .= $characters[rand(0, $charactersLength - 1)];
        }
        if ($model::where($col, $generate_random_code)->exists()) {
            generate_unique_code($model, $col, $length, $letter_type);
        }
        return $generate_random_code;
    }
}

if (!function_exists('setting')) {
    function setting(string $attr, string $dashboard = Setting::ERP)
    {
        if (Schema::hasTable('settings')) {
            $settings = (Cache::has('settings')) ? Cache::get('settings') : Cache::rememberForever('settings', function () use ($dashboard) {
                return Setting::where('dashboard', $dashboard)->get();
            });

            $setting = $settings->firstWhere('key', $attr)?->value;

            if (is_string($setting)) {
                (array)json_decode($setting);
            }

            if ($attr == 'erp_logo')
                $setting = isset($setting[app()->getLocale()]) ? asset('storage/images/setting') . "/" . $setting[app()->getLocale()] : asset('dashboardAsset/global/images/logo/cover_sm.png');

            return $setting[app()->getLocale()] ?? array_first($setting);
        }
        return;
    }
}
if (!function_exists('countries_list')) {
function countries_list($type=null, $locale = 'ar'){
    $countries = config('country');
    if ($type == "full"){
        $matches = [];
        foreach ($countries as $country) {
            $matches[] =  [
                'name' => $country["name_$locale"],
                'phone' => $country["phone"],
                'code' => $country["code"],
            ];
        }
        return $matches;
    }

    $codes = data_get($countries,'*.phone');
    return implode(',',$codes);
}
}
