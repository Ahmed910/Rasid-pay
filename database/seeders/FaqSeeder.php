<?php

namespace Database\Seeders;

use App\Models\Faq\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'is_active' => 1,
                'order' => 1,
                'ar' => [
                    'question' => 'السؤال الأول ',
                    'answer' => 'الإجابة الأولي',
                ]
            ],
            [
                'is_active' => 1,
                'order' => 1,
                'ar' => [
                    'question' => 'السؤال الثان ',
                    'answer' => 'الإجابة الثانية',
                ]
            ],
            [
                'is_active' => 1,
                'order' => 1,
                'ar' => [
                    'question' => 'السؤال الثالث ',
                    'answer' => 'الإجابة الثالثة',
                ]
            ],
            [
                'is_active' => 1,
                'order' => 1,
                'ar' => [
                    'question' => 'السؤال الرابع ',
                    'answer' => 'الإجابة الرابعة',
                ]
            ],
            [
                'is_active' => 1,
                'order' => 1,
                'ar' => [
                    'question' => 'السؤال الخامس ',
                    'answer' => 'الإجابة الخامسة',
                ]
            ],
        ];

        foreach ($data as  $value) {
            Faq::create($value);
        }
    }
}
