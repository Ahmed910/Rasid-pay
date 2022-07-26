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

        foreach ($trans as $single) {
            $country = Country::firstWhere(['currency_code' => $single['key']]);
            if ($country) {
                if ($country->translate('ar')) {
                    $country->translate('ar')->currency = $single['ar']['name'];
                }
                if ($country->translate('en')) {
                    $country->translate('en')->currency = $single['en']['name'];
                }
                $country->save();
            }
        }
    }
}
