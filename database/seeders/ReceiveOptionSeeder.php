<?php

namespace Database\Seeders;

use App\Models\RecieveOption\RecieveOption;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ReceiveOptionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $receiveOptions = [
            ['is_active' => 1, 'ar' => ['name' => 'ويسترن يونيون']]
        ];

        foreach ($receiveOptions as $receiveOption) {
            RecieveOption::create($receiveOption);
        }
    }
}
