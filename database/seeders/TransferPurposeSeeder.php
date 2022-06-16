<?php

namespace Database\Seeders;

use App\Models\TransferPurpose\TransferPurpose;
use Illuminate\Database\Seeder;

class TransferPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransferPurpose::factory()->count(10)->create();
    }
}
