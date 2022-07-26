<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // erp
            ["key" => "erp_title", "value" => ["en" => "Rasid Jack", "ar" => "رصيد باك"], "input_type" => "text"],
            ["key" => "erp_phone", "value" => ["en" => "1234567890,152364123,5123645523"], "input_type" => "text"],
            ["key" => "erp_logo", "value" => ["en" => "sample.png"], "input_type" => "file"],
            ["key" => "erp_description", "value" => ["en" => "Description", "ar" => "الوصف"], "input_type" => "editor"],

            // auth
            ["key" => "rasidpay_login_times", "value" => ["en" => 3], "input_type" => "number"],
            ["key" => "rasidpay_session_timeout", "value" => ["en" => 600], "input_type" => "number"],
            ["key" => "rasidpay_verificatoin_code", "value" => ["en" => 60], "input_type" => "number"],
            ["key" => "rasid_verify_code_timer", "value" => ["en" => 60], "input_type" => "number"],
            ["key" => "rasidpay_setting_termsconds", "value" => ["en" => "rasid pay setting terms and conditions", "ar" => "الشروط والاحكام"], "input_type" => "editor"],

            // statics
            ["key" => "rasidpay_setting_aboutapp", "value" => ["en" => "rasid pay setting about app", "ar" => "اعدادات عن التطبيق"], "input_type" => "editor"],
            ["key" => "rasidpay_setting_usagepolicy", "value" => ["en" => "rasid pay setting usage policy", "ar" => "اعدادات سياسة الاستخدام"], "input_type" => "editor"],
            ["key" => "rasid_date_type", "value" => ["en" => 0], "input_type" => "select"],
            ["key" => "rasidpay_localtransfer_creditchoice_active", "value" => ["en" => 0], "input_type" => "select"],
            ["key" => "rasidpay_inttransfer_creditchoice_active", "value" => ["en" => 0], "input_type" => "select"],

            // rasid maak
            ["key" => "rasidback_rasidmaak_specifications", "value" => ["en" => "Rasid maak", "ar" => "رصيد معاك"], "input_type" => "text"],
            ["key" => "rasidpay_rasidmaak_specifications", "value" => ["en" => "Enjoy a special installment rate with the application of credit with you, download it now", "ar" => "تمتع بنسبة تقسيط خاصة مع تطبيق رصيد معاك حمله الآن"], "input_type" => "text"],

            // transfers
            ["key" => "rasidpay_localtransfer_transferfees", "value" => ["en" => 7], "input_type" => "number"],
            ["key" => "rasidpay_calc_transfer_fees", "value" => ["en" => 2], "input_type" => "number"],
            ["key" => "rasidpay_transfer_tax", "value" => ["en" => 2], "input_type" => "number"],

            // message
            ["key" => "rasid_support_msgsinbox_reply", "value" => ["en" => 0], "input_type" => "select"],
            // transactions
            ["key" => "rasidpay_mytransactoins_displaycount", "value" => ["en" => 5], "input_type" => "number"],
            // wallet transfers
            ["key" => "rasidpay_wallettransfer_minvalue", "value" => ["en" => 10], "input_type" => "number"],
            ["key" => "rasidpay_wallettransfer_maxvalue", "value" => ["en" => 10000], "input_type" => "number"],
            ["key" => "rasidpay_wallettransfer_maxvalue_perday", "value" => ["en" => 100000], "input_type" => "number"],
            ["key" => "rasidpay_wallettransfer_maxvalue_permonth", "value" => ["en" => 1000000], "input_type" => "number"],
            ["key" => "rasidpay_wallettransfer_maxvalue_perreciever", "value" => ["en" => 1000], "input_type" => "number"],

            // wallet charge
            ["key" => "rasidpay_walletcharge_minvalue", "value" => ["en" => 10], "input_type" => "number"],
            ["key" => "rasidpay_walletcharge_maxvalue", "value" => ["en" => 10000], "input_type" => "number"],

            // local transfers
            ["key" => "rasidpay_localtransfer_minvalue", "value" => ["en" => 10], "input_type" => "number"],
            ["key" => "rasidpay_localtransfer_maxvalue", "value" => ["en" => 10000], "input_type" => "number"],
            ["key" => "rasidpay_localtransfer_country", "value" => ["en" => 'SA', 'ar' => 'المملكة العربية السعودية'], "input_type" => "number"],
            ["key" => "rasidpay_localtransfer_currency", "value" => ["en" => 'SAR', 'ar' => 'ريال سعودي'], "input_type" => "number"],

            // global transfers
            ["key" => "rasidpay_inttransfer_minvalue", "value" => ["en" => 10], "input_type" => "number"],
            ["key" => "rasidpay_inttransfer_maxvalue", "value" => ["en" => 10000], "input_type" => "number"],

            //social
            ["key" => "rasid_social_fb_link", "value" => ["en" => "www.facebook.com/alfintect"], "input_type" => "text"],
            ["key" => "rasid_social_linkedin_link", "value" => ["en" => "www.linkedin.com/alfintect"], "input_type" => "text"],
            ["key" => "rasid_social_instagram_link", "value" => ["en" => "www.instagram.com/alfintect"], "input_type" => "text"],
            ["key" => "rasid_social_twitter_link", "value" => ["en" => "www.twitter.com/alfintect"], "input_type" => "text"],
            ["key" => "rasid_social_whatsapp_link", "value" => ["en" => "00966501386700"], "input_type" => "text"],
            ["key" => "rasid_website_link", "value" => ["en" => "https://alfintech.com.eg/"], "input_type" => "text"],

            // contacts
            ["key" => "rasid_mobile_no", "value" => ["en" => "00966501386700"], "input_type" => "text"],
            ["key" => "rasid_phone_no", "value" => ["en" => "00966512345678"], "input_type" => "text"],
            ["key" => "rasid_mail", "value" => ["en" => "info@fintech-sa.com"], "input_type" => "text"],
            ["key" => "rasid_fax_no", "value" => ["en" => "123456"], "input_type" => "text"],
            ["key" => "rasid_hotline_no", "value" => ["en" => "19999"], "input_type" => "text"],

            // packages
            ["key" => "rasidpay_cards_basic_desc", "value" => ["en" => "rasid pay cards basic description", "ar" => "وصف مختصر لبطاقة الدفع الاساسية"], "input_type" => "textarea"],
            ["key" => "rasidpay_cards_golden_desc", "value" => ["en" => "rasid pay cards golden description", "ar" => "وصف مختصر لبطاقة الدفع الذهبية"], "input_type" => "textarea"],
            ["key" => "rasidpay_cards_platinum_desc", "value" => ["en" => "rasid pay cards platinum description", "ar" => "وصف مختصر لبطاقة الدفع البلاتينية"], "input_type" => "textarea"],
            ["key" => "rasidpay_cards_basic_price", "value" => ["en" => "2000"], "input_type" => "text"],
            ["key" => "rasidpay_cards_golden_price", "value" => ["en" => "3000"], "input_type" => "text"],
            ["key" => "rasidpay_cards_platinum_price", "value" => ["en" => "4000"], "input_type" => "text"],
            ["key" => "rasidpay_cards_basic_color", "value" => ["en" => "3553AA"], "input_type" => "text"],
            ["key" => "rasidpay_cards_golden_color", "value" => ["en" => "D5AB42"], "input_type" => "text"],
            ["key" => "rasidpay_cards_platinum_color", "value" => ["en" => "2D2D2D"], "input_type" => "text"],
            ["key" => "rasidpay_cards_basic_bgimg", "value" => ["en" => "/assets/images/packages/blue_card.png"], "input_type" => "text"],
            ["key" => "rasidpay_cards_golden_bgimg", "value" => ["en" => "/assets/images/packages/yellow_card.png"], "input_type" => "text"],
            ["key" => "rasidpay_cards_platinum_bgimg", "value" => ["en" => "/assets/images/packages/black_card.png"], "input_type" => "text"],
            ["key" => "rasidpay_marketingemp_commissionrate", "value" => ["en" => "20"], "input_type" => "text"],
            ["key" => "rasidpay_platinum_firstcode_activatebonus", "value" => ["en" => "10"], "input_type" => "text"],
            ["key" => "rasidpay_platinum_secondcode_activatebonus", "value" => ["en" => "11"], "input_type" => "text"],
            ["key" => "rasidpay_platinum_thirdcode_activatebonus", "value" => ["en" => "12"], "input_type" => "text"],
            ["key" => "rasidpay_platinum_fourthcode_activatebonus", "value" => ["en" => "15"], "input_type" => "text"],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
