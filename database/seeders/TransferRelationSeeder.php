<?php

namespace Database\Seeders;

use App\Models\TransferRelation\TransferRelation;
use Illuminate\Database\Seeder;

class TransferRelationSeeder extends Seeder
{
    public function run()
    {
        $relations = [
            ['is_active' => 1, 'ar' => ['name' => 'أقارب/أصدقاء']],
            ['is_active' => 1, 'ar' => ['name' => 'موظف']],
            ['is_active' => 1, 'ar' => ['name' => 'عمالة منزلية']],
            ['is_active' => 1, 'ar' => ['name' => 'عمل/موظفين']],
        ];

        foreach ($relations as $relation) {
            TransferRelation::create($relation);
        }
    }
}
