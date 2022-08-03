<?php

namespace Database\Seeders;

use App\Models\Country\Country;
use Illuminate\Database\Seeder;

class CountryTransSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trans = include database_path('Intial_data/countries_trans.php');
        $countries = collect(config("country"));
        foreach ($trans as $single) {
            $country = Country::firstWhere(['currency_code' => $single['key']]);
            $country_trans = $countries->firstWhere('currency_code', $single['key']);

            if ($country) {
                $country->translations()->updateOrCreate(['currency' => $country?->currency],
                    [
                        'currency' => $single['ar']['name'],
                        'locale' => 'ar', 'name' => $country_trans['name_ar'],
                        'nationality' => $country_trans['name_ar']
                    ]);
            }
        }
    }
}
