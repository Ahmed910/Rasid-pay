<?php

namespace Database\Factories\TransferPurpose;

use App\Models\TransferPurpose\TransferPurpose;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferPurposeFactory extends Factory
{
    protected $model = TransferPurpose::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'is_active'=>$this->faker->boolean,
            'name' => $this->faker->name
        ];
    }
}
