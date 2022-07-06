<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [
            'key' => 'mobile',
            'key' => 'mobile_register_term_conditions',
            'key' => 'global_transfers',
        ];


        foreach ($links as $link) {
            Link::create($link);
        }
    }
}
