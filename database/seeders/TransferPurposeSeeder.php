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
        TransferPurpose::create([
            'ar' => ['name' => 'أخرى'],
            'is_another' => true,
            'is_active'  => true
        ]);
    }
}
