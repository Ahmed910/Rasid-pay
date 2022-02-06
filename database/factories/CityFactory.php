<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          "id"=>$this->faker->uuid() ,
        "name"=>$this->faker->city()   ,
       "region"=>$this->faker->citySuffix() ,
        "code"=>  $this->faker->countryCode ,
        ];
    }
}
