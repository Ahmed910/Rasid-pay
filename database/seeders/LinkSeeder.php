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
            ['key' => 'mobile.register_policy'],
            ['key' => 'mobile.charge_policy'],
            ['key' => 'mobile.local_transfer_policy'],
            ['key' => 'mobile.global_transfer_policy'],
        ];


        foreach ($links as $link) {
            Link::create($link);
        }
    }
}
