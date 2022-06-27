<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;

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

        foreach ($authTranslations as $translation) {
            Translation::create($translation);
        }
    }
}
