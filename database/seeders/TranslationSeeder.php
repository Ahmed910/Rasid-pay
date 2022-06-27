<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authTranslations = include database_path('Intial_data/translations.php');

        $trans = include resource_path('lang/ar/dashboard.php');
    Arr::dot($trans);
        foreach ($authTranslations as $translation) {
            Translation::create($translation);
        }
    }
}
