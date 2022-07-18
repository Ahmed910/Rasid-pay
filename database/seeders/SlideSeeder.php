<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::unprepared(include database_path('Intial_data/slide.php'));
    }
}
