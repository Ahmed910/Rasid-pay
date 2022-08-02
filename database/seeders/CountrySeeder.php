<?php

namespace Database\Seeders;

use App\Models\Country\Country;
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
            Country::create([
                "phone_code" => $country["phone"],
                "currency_code" => $country["currency_code"],
                'ar' => [
                    'name' => $country['name_ar'],
                    'nationality' => $country['name_ar'],
                    'currency' => $country['currency_ar'],
                ]
            ]);
        }

    }

}
