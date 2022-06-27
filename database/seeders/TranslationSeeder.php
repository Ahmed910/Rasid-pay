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
        $translations = include database_path('Intial_data/translations.php');

        foreach ($translations as $translation) {
            Translation::create($translation);
        }
    }
}
