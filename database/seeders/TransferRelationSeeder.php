<?php

namespace Database\Seeders;

use App\Models\TransferRelation\TransferRelation;
use Illuminate\Database\Seeder;

class TransferRelationSeeder extends Seeder
{
    public function run()
    {
        $relations = [
            ['is_active' => 1, 'ar' => ['name' => 'أقارب']],
            ['is_active' => 1, 'ar' => ['name' => 'موظف']],
        ];

        foreach ($relations as $relation) {
            TransferRelation::create($relation);
        }
    }
}
