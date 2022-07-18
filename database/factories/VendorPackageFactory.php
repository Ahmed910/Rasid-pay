<?php

namespace Database\Factories;

use App\Models\Vendor\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'basic_discount' => $this->faker->numberBetween(0, 100),
            'golden_discount' => $this->faker->numberBetween(0, 100),
            'platinum_discount' => $this->faker->numberBetween(0, 100),
            'vendor_id' => $this->getRandomVednorId()
        ];
    }

    private function getRandomVednorId(int $number = null)
    {
        static $collection;
        if (!$collection) $collection = Vendor::pluck('id');

        return $collection->random(min($number, $collection->count()));
    }
}
