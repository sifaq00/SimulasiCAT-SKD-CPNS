<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
                'name' => 'Tes Intelegensi Umum',
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

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['code' => $category['code']],
                $category
            );
        }
    }
}
