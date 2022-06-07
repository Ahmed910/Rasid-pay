<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{

    public function definition()
    {
        $transactionStatues = ['success', 'fail', 'pending', 'received', 'cancel'];
        $transactionTypes   = ['payment', 'wallet_transfer', 'bank_transaction', 'receive_credit', 'recharge_credit', 'upgrade_card'];

        return [
            'to_user_id' => $this->getRandomUserId(),
            'from_user_id' => $this->getRandomUserId(),
            'amount' => $this->faker->numberBetween(1,1000),
            'status' => $this->faker->randomElement($transactionStatues),
            'type' => $this->faker->randomElement($transactionTypes),
            'transaction_id' => uniqid(),
            'created_at' => $this->faker->date()
        ];
    }

    private function getRandomUserId(int $number = null)
    {
        static $collection;
        if (!$collection) $collection = User::pluck('id');

        return $collection->random(min($number, $collection->count()));
    }
}
