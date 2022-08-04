<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Locale\Locale;
use App\Models\Locale\LocaleTranslation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Locale::insert(include database_path('Intial_data/locales.php'));
        LocaleTranslation::insert(include database_path('Intial_data/locale_trans.php'));
    }
}
