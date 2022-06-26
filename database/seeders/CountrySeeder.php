<?php

namespace Database\Seeders;

use App\Models\Country\Country;
use App\Models\Country\CountryTranslation;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = config("country");
        foreach ($countries as $country) {
            $currentcountry = Country::create(

                ["phone_code" => $country["phone"]]

            );

            CountryTranslation::create([

                'country_id' => $currentcountry->id,
                'name' => $country['name_ar'],
                'nationality' => $country['name_ar'],
                'locale' => 'ar',
            ]);
            CountryTranslation::create([

                'country_id' => $currentcountry->id,
                'name' => $country['name_en'],
                'nationality' => $country['name_en'],
                'locale' => "en",
            ]);
        }

    }

}
