<?php

use App\Models\Setting;
use Carbon\Carbon;
use GeniusTS\HijriDate\{Date, Hijri, Translations\Arabic, Translations\English};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

if (!function_exists('check_phone_valid')) {
    function check_phone_valid($number)
    {
        return preg_match('/^(:?(\+)|(00))?(:?966)?+(5|05)([503649187])([0-9]{7})$/', $number);
    }
}

if (!function_exists('check_password_vaild')) {
    function check_password_vaild($password)
    {
        return preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/', $password);
    }
}

if (!function_exists('check_iban_valid')) {
    function check_iban_valid($iban, $country = null)
    {
        $iban = strtolower(str_replace(' ', '', $iban));
        $Countries = [
            'al' => 28, 'ad' => 24, 'at' => 20, 'az' => 28, 'bh' => 22, 'be' => 16,
            'ba' => 20, 'br' => 29, 'bg' => 22, 'cr' => 21, 'hr' => 21, 'cy' => 28,
            'cz' => 24, 'dk' => 18, 'do' => 28, 'ee' => 20, 'fo' => 18, 'fi' => 18,
            'fr' => 27, 'ge' => 22, 'de' => 22, 'gi' => 23, 'gr' => 27, 'gl' => 18,
            'gt' => 28, 'hu' => 28, 'is' => 26, 'ie' => 22, 'il' => 23, 'it' => 27,
            'jo' => 30, 'kz' => 20, 'kw' => 30, 'lv' => 21, 'lb' => 28, 'li' => 21,
            'lt' => 20, 'lu' => 20, 'mk' => 19, 'mt' => 31, 'mr' => 27, 'mu' => 30,
            'mc' => 27, 'md' => 24, 'me' => 22, 'nl' => 18, 'no' => 15, 'pk' => 24,
            'ps' => 29, 'pl' => 28, 'pt' => 25, 'qa' => 29, 'ro' => 24, 'sm' => 27,
            'sa' => 24, 'rs' => 22, 'sk' => 24, 'si' => 19, 'es' => 24, 'se' => 24,
            'ch' => 21, 'tn' => 24, 'tr' => 26, 'ae' => 23, 'gb' => 22, 'vg' => 24
        ];
        $Chars = [
            'a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15, 'g' => 16,
            'h' => 17, 'i' => 18, 'j' => 19, 'k' => 20, 'l' => 21, 'm' => 22, 'n' => 23,
            'o' => 24, 'p' => 25, 'q' => 26, 'r' => 27, 's' => 28, 't' => 29, 'u' => 30,
            'v' => 31, 'w' => 32, 'x' => 33, 'y' => 34, 'z' => 35
        ];

        if (strlen($iban) == @$Countries[$country ?? substr($iban, 0, 2)]) {

            $MovedChar = substr($iban, 4) . substr($iban, 0, 4);
            $MovedCharArray = str_split($MovedChar);
            $NewString = "";

            foreach ($MovedCharArray as $key => $value) {
                if (!is_numeric($MovedCharArray[$key])) {
                    $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
                }
                $NewString .= $MovedCharArray[$key];
            }

            if (bcmod($NewString, '97') == 1) {
                return true;
            }
        }
        return false;
    }
}

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

if (!function_exists('db_translations')) {;
    function db_translations(string $locale = null, $file = null): Collection
    {
        if (Schema::hasTable('locales')) {
            //TODO: Add Cache
            $translation = \App\Models\Locale\Locale::join('locale_translations', 'locale_translations.locale_id', '=', 'locales.id')
                ->when($locale != null, fn($q) => $q->where('locale', $locale))
                ->addSelect('locale_id', 'key', 'locale', 'value', 'desc')
                ->when($file != null, fn ($q) => $q->where('file', $file))
                ->get();

            return $translation;
        }
        return collect([]);
    }
}

if (!function_exists('countries_list')) {
    function countries_list($type = null, $locale = 'ar')
    {
        $countries = config('country');
        if ($type == "full") {
            $matches = [];
            foreach ($countries as $country) {
                $matches[] =  [
                    'name' => $country["name_$locale"],
                    'phone' => $country["phone"],
                    'code' => $country["code"],
                    'emoji' => $country["emoji"],
                ];
            }
            return $matches;
        }

        $codes = data_get($countries, '*.phone');
        return implode(',', $codes);
    }
}

if (!function_exists('transform_array_api')) {
    function transform_array_api(array $array, string $transVariable): Collection
    {
        $data = collect($array)->transform(function ($item) use ($transVariable) {
            $data['type'] = $item;
            $data['trans'] = trans("$transVariable.{$item}");

            return $data;
        });

        return $data;
    }
}

if (!function_exists('format_date')) {
    function format_date(?string $date)
    {
        if (is_null($date)) return null;

        if (auth()->check() && auth()->user()->is_date_hijri) {

            if (app()->getLocale() == 'en') {
                Date::setTranslation(new English);
                Date::setDefaultNumbers(Date::ARABIC_NUMBERS);
            } else {
                Date::setTranslation(new Arabic);
                Date::setDefaultNumbers(Date::INDIAN_NUMBERS);
            }

            return Hijri::convertToHijri($date)->format('d F o');
        }
        return Carbon::parse($date)->locale(app()->getLocale())->translatedFormat('j F Y');
    }
}

if (!function_exists('getPercentOfNumber')) {
    function getPercentOfNumber($number, $percent)
    {
        return ($percent / 100) * $number;
    }
}
