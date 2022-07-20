<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ["key" => "erp_title", "value" => ["en" => "Rasid Jack", "ar" => "رصيد باك"], "input_type" => "text"],
            ["key" => "erp_phone", "value" => ["en" => "1234567890,152364123,5123645523"], "input_type" => "text"],
            ["key" => "erp_logo", "value" => ["en" => "sample.png"], "input_type" => "file"],
            ["key" => "erp_description", "value" => ["en" => "Description", "ar" => "الوصف"], "input_type" => "editor"],
            ["key" => "rasidpay_login_times", "value" => ["en" => 3], "input_type" => "number"],
            ["key" => "rasidpay_setting_termsconds", "value" => ["en" => "rasidpay setting termsconds", "ar" => "rasidpay setting termsconds"], "input_type" => "editor"],
            ["key" => "rasidpay_setting_aboutapp", "value" => ["en" => "rasidpay_setting_aboutapp", "ar" => "rasidpay_setting_aboutapp"], "input_type" => "editor"],
            ["key" => "rasidpay_setting_usagepolicy", "value" => ["en" => "rasidpay_setting_usagepolicy", "ar" => "rasidpay_setting_usagepolicy"], "input_type" => "editor"],
            ["key" => "rasid_date_type", "value" => ["en" => 1, "ar" => 1], "input_type" => "select"],
            ["key" => "rasidback_rasidmaak_specifications", "value" => ["en" => "Rasid", "ar" => "رصيد"], "input_type" => "text"],

            ["key" => "pay_cards_basic_desc", "value" => ["en" => "pay cards basic description"], "input_type" => "textarea"],
            ["key" => "pay_cards_golden_desc", "value" => ["en" => "pay cards golden description"], "input_type" => "textarea"],
            ["key" => "pay_cards_platinum_desc", "value" => ["en" => "pay cards platinum description"], "input_type" => "textarea"],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
