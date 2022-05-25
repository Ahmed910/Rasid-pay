<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ["key" => "erp_title", "value" => ["en" => "Rasid Jack", "ar" => "رصيد باك"], "input_type" => "text", "dashboard" => Setting::ERP],
            ["key" => "erp_phone", "value" => ["en" => "1234567890,152364123,5123645523"], "input_type" => "text", "dashboard" => Setting::ERP],
            ["key" => "erp_logo", "value" => ["en" => "sample.png"], "input_type" => "file", "dashboard" => Setting::ERP],
            ["key" => "erp_description", "value" => ["en" => "Description", "ar" => "الوصف"], "input_type" => "editor", "dashboard" => Setting::ERP],
            ["key" => "pay_cards_basic_desc", "value" => ["en" => "pay cards basic description"], "input_type" => "textarea", "dashboard" => Setting::RASID_PAY],
            ["key" => "pay_cards_golden_desc", "value" => ["en" => "pay cards golden description"], "input_type" => "textarea", "dashboard" => Setting::RASID_PAY],
            ["key" => "pay_cards_platinum_desc", "value" => ["en" => "pay cards platinum description"], "input_type" => "textarea", "dashboard" => Setting::RASID_PAY],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
