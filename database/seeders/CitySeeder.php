<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\City\City::factory(10)->create();
//        $faker=Factory::create();
//        for ($i=0;$i<=10;$i++){
//            City::create([
//                'name'=>$faker->city(),
//                'region'=>$faker->citySuffix(100),
//                'code'=>$faker->countryCode
//            ]);
//        }
    }
}
