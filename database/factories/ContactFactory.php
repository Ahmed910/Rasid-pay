<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = $this->getRandomUser();
        return [
            'user_id' => $user->id,
            'fullname' => $user->fullname,
            'email' => $user->email,
            'phone' => $user->phone,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'message_source' => $this->faker->randomElement(['website','app',]),
            'message_status' => $this->faker->randomElement(['pending','new',"replied"]),
            'contact_type' => $this->faker->randomElement(['complain', 'inquiries', 'suggestions']),
            'admin_id' => $this->getRandomUser()->id,
        ];
    }

    private function getRandomUser(int $number = null)
    {
        static $collection;
        if (!$collection) $collection = User::all();

        return $collection->random(min($number, $collection->count()));
    }
}
