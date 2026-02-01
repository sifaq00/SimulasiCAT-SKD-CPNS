<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Option;
use App\Models\Package;
use App\Models\Question;
use Illuminate\Database\Seeder;

class AllPackagesQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $packages = Package::all();
        
        if ($packages->isEmpty()) {
            $this->command->info('No packages found!');
            return;
        }

        // Get categories
        $twk = Category::where('code', 'TWK')->first();
        $tiu = Category::where('code', 'TIU')->first();
        $tkp = Category::where('code', 'TKP')->first();

        if (!$twk || !$tiu || !$tkp) {
            $this->command->info('Categories (TWK, TIU, TKP) not found!');
            return;
        }

        // Clean up existing questions/options to avoid duplicates
        $this->command->info('Cleaning up existing questions and options...');
        Option::query()->delete();
        Question::query()->delete();

        foreach ($packages as $package) {
            $this->command->info("Adding 110 questions to {$package->name}...");
            $order = 1;

            // 1. TWK (30 Questions)
            $this->command->info(" - Generating 30 TWK questions...");
            for ($i = 1; $i <= 30; $i++) {
                $question = Question::create([
                    'package_id' => $package->id,
                    'category_id' => $twk->id,
                    'question_text' => "Pertanyaan TWK #{$i} untuk paket {$package->name}. Ini adalah soal pengetahuan umum kebangsaan.",
                    'order_number' => $order++,
                    'explanation' => "Pembahasan Soal TWK #{$i}. Jawaban yang benar adalah pilihan A.",
                ]);

                $correctOptionId = null;
                for ($j = 1; $j <= 5; $j++) {
                    $label = chr(64 + $j); // A, B, C, D, E
                    $isCorrect = ($j === 1); // Option A is always correct for these samples
                    $option = Option::create([
                        'question_id' => $question->id,
                        'label' => $label,
                        'option_text' => "Jawaban {$label} untuk soal TWK #{$i}",
                        'points' => $isCorrect ? 5 : 0,
                        'is_correct' => $isCorrect,
                    ]);

                    if ($isCorrect) {
                        $correctOptionId = $option->id;
                    }
                }
                $question->update(['correct_option_id' => $correctOptionId]);
            }

            // 2. TIU (35 Questions)
            $this->command->info(" - Generating 35 TIU questions...");
            for ($i = 1; $i <= 35; $i++) {
                $question = Question::create([
                    'package_id' => $package->id,
                    'category_id' => $tiu->id,
                    'question_text' => "Pertanyaan TIU #{$i} untuk paket {$package->name}. Ini adalah soal logika dan kemampuan numerik.",
                    'order_number' => $order++,
                    'explanation' => "Pembahasan Soal TIU #{$i}. Logika pengerjaan soal ini sangat sederhana.",
                ]);

                $correctOptionId = null;
                for ($j = 1; $j <= 5; $j++) {
                    $label = chr(64 + $j);
                    $isCorrect = ($j === 1); 
                    $option = Option::create([
                        'question_id' => $question->id,
                        'label' => $label,
                        'option_text' => "Jawaban {$label} untuk soal TIU #{$i}",
                        'points' => $isCorrect ? 5 : 0,
                        'is_correct' => $isCorrect,
                    ]);

                    if ($isCorrect) {
                        $correctOptionId = $option->id;
                    }
                }
                $question->update(['correct_option_id' => $correctOptionId]);
            }

            // 3. TKP (45 Questions)
            $this->command->info(" - Generating 45 TKP questions...");
            for ($i = 1; $i <= 45; $i++) {
                $question = Question::create([
                    'package_id' => $package->id,
                    'category_id' => $tkp->id,
                    'question_text' => "Pertanyaan TKP #{$i} untuk paket {$package->name}. Bagaimana sikap Anda menghadapi situasi pelayanan publik ini?",
                    'order_number' => $order++,
                    'explanation' => "Dalam TKP, sikap melayani dan profesionalitas adalah yang utama. Pilihan C memiliki poin tertinggi.",
                ]);

                for ($j = 1; $j <= 5; $j++) {
                    $label = chr(64 + $j);
                    // TKP points: usually 1-5. Let's make C=5, B=4, A=3, D=2, E=1
                    $pointsMap = ['A' => 3, 'B' => 4, 'C' => 5, 'D' => 2, 'E' => 1];
                    Option::create([
                        'question_id' => $question->id,
                        'label' => $label,
                        'option_text' => "Jawaban {$label} (Skor: {$pointsMap[$label]}) untuk soal TKP #{$i}",
                        'points' => $pointsMap[$label],
                        'is_correct' => ($label === 'C'), // UI might still use this
                    ]);
                }
            }
        }

        $this->command->info('Successfully added 110 questions to all packages!');
    }
}
