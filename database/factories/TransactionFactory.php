<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{

    public function definition()
    {
        $transactionStatues = Transaction::TYPES;
        $transactionTypes   = Transaction::TRANACTION_TYPES;

        return [
            'to_user_id' => $this->getRandomUserId(),
            'from_user_id' => $this->getRandomUserId(),
            'amount' => $this->faker->numberBetween(1,1000),
            'trans_status' => $this->faker->randomElement($transactionStatues),
            'trans_type' => $this->faker->randomElement($transactionTypes),
            'transaction_id' => uniqid(),
            'trans_number' => $this->faker->numberBetween(10000)
        ];
    }

    private function getRandomUserId(int $number = null)
    {
        static $collection;
        if (!$collection) $collection = User::pluck('id');

        return $collection->random(min($number, $collection->count()));
    }
}
