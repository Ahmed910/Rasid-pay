<?php

namespace Database\Seeders;

use App\Models\TransferFee;
use Illuminate\Database\Seeder;

class TransferFeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $transfer_fees = [
            ['amount_from' => 0 ,'amount_to' => 100 ,'amount_fee' => 14],
            ['amount_from' => 101 ,'amount_to' => 200 ,'amount_fee' => 21],
            ['amount_from' => 201 ,'amount_to' => 300 ,'amount_fee' => 27],
            ['amount_from' => 301 ,'amount_to' => 400 ,'amount_fee' => 32]
        ];
        foreach ($transfer_fees as $transfer_fee) {
            TransferFee::create($transfer_fee);
        }
       
    }
}
