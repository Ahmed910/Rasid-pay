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
            ['key' => 'mobile.page1'],
            ['key' => 'mobile.page2'],
            ['key' => 'mobile.page3'],
            ['key' => 'mobile.page4'],
            ['key' => 'mobile.page5'],
            ['key' => 'mobile.page6'],
        ];


        foreach ($links as $link) {
            Link::create($link);
        }
    }
}
