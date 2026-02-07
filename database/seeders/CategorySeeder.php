<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tes Wawasan Kebangsaan',
                'code' => 'TWK',
                'passing_grade' => 65,
                'max_score' => 150,
                'question_count' => 30,
            ],
            [
                'name' => 'Tes Intelegensia Umum',
                'code' => 'TIU',
                'passing_grade' => 80,
                'max_score' => 175,
                'question_count' => 35,
            ],
            [
                'name' => 'Tes Karakteristik Pribadi',
                'code' => 'TKP',
                'passing_grade' => 166,
                'max_score' => 225,
                'question_count' => 45,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['code' => $categoryData['code']],
                $categoryData
            );
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}
