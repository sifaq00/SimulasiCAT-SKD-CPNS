<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use App\Models\Category;
use App\Models\Question;
use App\Models\Option;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $packages = Package::all();
        $categories = Category::all();

        if ($packages->isEmpty() || $categories->isEmpty()) {
            $this->command->error('❌ Please run PackageSeeder and CategorySeeder first!');
            return;
        }

        foreach ($packages as $package) {
            $this->command->info("📝 Seeding questions for: {$package->name}");

            $orderNumber = 1;

            foreach ($categories as $category) {
                // Limit free package to 10 questions per category (30 total)
                $questionCount = $package->is_free ? 10 : $category->question_count;

                $points = $category->code === 'TKP' ? 5 : 5; // TKP = 5 points, others = 5 points

                for ($i = 1; $i <= $questionCount; $i++) {
                    $question = Question::create([
                        'package_id' => $package->id,
                        'category_id' => $category->id,
                        'question_text' => $this->generateQuestionText($category->code, $i),
                        'question_image' => null,
                        'explanation' => $this->generateExplanation($category->code, $i),
                        'points' => $points,
                        'order_number' => $orderNumber++,
                    ]);

                    // Create options
                    $options = $this->createOptions($question, $category->code);

                    // Set correct option
                    $correctOption = $options->first();
                    $question->update(['correct_option_id' => $correctOption->id]);
                }
            }

            $totalQuestions = $orderNumber - 1;
            $this->command->info("✅ Created {$totalQuestions} questions for {$package->name}");
        }

        $this->command->info('✅ All questions seeded successfully!');
    }

    private function generateQuestionText(string $categoryCode, int $number): string
    {
        $templates = [
            'TWK' => "Soal TWK #{$number}: Pertanyaan tentang Pancasila, UUD 1945, NKRI, Bhinneka Tunggal Ika, dan wawasan kebangsaan Indonesia.",
            'TIU' => "Soal TIU #{$number}: Pertanyaan tentang kemampuan verbal, numerik, logika, dan analisis untuk mengukur intelegensia umum.",
            'TKP' => "Soal TKP #{$number}: Pertanyaan tentang karakteristik pribadi, integritas, kejujuran, dan adaptabilitas dalam situasi kerja.",
        ];

        return $templates[$categoryCode] ?? "Soal {$categoryCode} #{$number}";
    }

    private function generateExplanation(string $categoryCode, int $number): string
    {
        $explanations = [
            'TWK' => "Pembahasan untuk soal TWK #{$number}: Materi ini berkaitan dengan pemahaman mendalam tentang nilai-nilai kebangsaan Indonesia dan implementasinya dalam kehidupan berbangsa dan bernegara.",
            'TIU' => "Pembahasan untuk soal TIU #{$number}: Untuk menyelesaikan soal ini, gunakan logika dan kemampuan analitis. Perhatikan pola, hubungan antar elemen, dan gunakan metode eliminasi untuk pilihan yang kurang tepat.",
            'TKP' => "Pembahasan untuk soal TKP #{$number}: Pilihan jawaban mencerminkan tingkat integritas dan profesionalisme. Selalu pilih jawaban yang menunjukkan sikap proaktif, bertanggung jawab, dan sesuai dengan nilai-nilai ASN yang berintegritas.",
        ];

        return $explanations[$categoryCode] ?? "Pembahasan untuk soal {$categoryCode} #{$number}";
    }

    private function createOptions(Question $question, string $categoryCode)
    {
        $labels = ['A', 'B', 'C', 'D', 'E'];

        if ($categoryCode === 'TKP') {
            // TKP has weighted options (1-5 points)
            $optionsData = [
                ['label' => 'A', 'option_text' => 'Sangat Setuju - Menunjukkan sikap paling ideal dan profesional', 'points' => 5, 'is_correct' => true],
                ['label' => 'B', 'option_text' => 'Setuju - Menunjukkan sikap yang baik dan sesuai', 'points' => 4, 'is_correct' => false],
                ['label' => 'C', 'option_text' => 'Netral - Sikap yang cukup, namun tidak terlalu menonjol', 'points' => 3, 'is_correct' => false],
                ['label' => 'D', 'option_text' => 'Tidak Setuju - Kurang menunjukkan sikap yang diharapkan', 'points' => 2, 'is_correct' => false],
                ['label' => 'E', 'option_text' => 'Sangat Tidak Setuju - Tidak menunjukkan sikap yang diharapkan', 'points' => 1, 'is_correct' => false],
            ];
        } else {
            // TWK and TIU have regular options (correct = points, wrong = 0)
            $optionsData = [
                ['label' => 'A', 'option_text' => 'Pilihan A - Jawaban yang benar dengan penjelasan logis', 'points' => 0, 'is_correct' => true],
                ['label' => 'B', 'option_text' => 'Pilihan B - Jawaban yang salah, pengecoh pertama', 'points' => 0, 'is_correct' => false],
                ['label' => 'C', 'option_text' => 'Pilihan C - Jawaban yang salah, pengecoh kedua', 'points' => 0, 'is_correct' => false],
                ['label' => 'D', 'option_text' => 'Pilihan D - Jawaban yang salah, pengecoh ketiga', 'points' => 0, 'is_correct' => false],
                ['label' => 'E', 'option_text' => 'Pilihan E - Jawaban yang salah, pengecoh keempat', 'points' => 0, 'is_correct' => false],
            ];
        }

        $options = collect();
        foreach ($optionsData as $optionData) {
            $option = Option::create([
                'question_id' => $question->id,
                'label' => $optionData['label'],
                'option_text' => $optionData['option_text'],
                'points' => $optionData['points'],
                'is_correct' => $optionData['is_correct'],
            ]);
            $options->push($option);
        }

        return $options;
    }
}
