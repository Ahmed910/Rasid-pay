<?php

namespace Database\Factories\Region;

use Illuminate\Database\Eloquent\Factories\Factory;

class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'=>$this->faker->uuid() ,
            'name' => $this->faker->city(),
             "country_id" =>1  ,
        ];
    }
}
