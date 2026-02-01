<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Option;
use App\Models\Package;
use App\Models\Question;
use Illuminate\Database\Seeder;

class Skd2019QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $package = Package::where('slug', 'skd-cpns-2019')->first();
        
        if (!$package) {
            $this->command->info('Package SKD CPNS 2019 not found!');
            return;
        }

        // Get categories
        $twk = Category::where('code', 'TWK')->first();
        $tiu = Category::where('code', 'TIU')->first();
        $tkp = Category::where('code', 'TKP')->first();

        if (!$twk || !$tiu || !$tkp) {
            $this->command->info('Categories not found!');
            return;
        }

        $order = 1;

        // TWK Questions (2 sample)
        $twkQuestions = [
            [
                'text' => 'Siapakah presiden pertama Indonesia?',
                'options' => [
                    ['label' => 'A', 'text' => 'Soekarno', 'points' => 5, 'is_correct' => true],
                    ['label' => 'B', 'text' => 'Soeharto', 'points' => 0, 'is_correct' => false],
                    ['label' => 'C', 'text' => 'Habibie', 'points' => 0, 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Megawati', 'points' => 0, 'is_correct' => false],
                    ['label' => 'E', 'text' => 'Jokowi', 'points' => 0, 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Hari kemerdekaan Indonesia jatuh pada tanggal?',
                'options' => [
                    ['label' => 'A', 'text' => '17 Juli 1945', 'points' => 0, 'is_correct' => false],
                    ['label' => 'B', 'text' => '17 Agustus 1945', 'points' => 5, 'is_correct' => true],
                    ['label' => 'C', 'text' => '17 September 1945', 'points' => 0, 'is_correct' => false],
                    ['label' => 'D', 'text' => '17 Oktober 1945', 'points' => 0, 'is_correct' => false],
                    ['label' => 'E', 'text' => '17 November 1945', 'points' => 0, 'is_correct' => false],
                ],
            ],
        ];

        foreach ($twkQuestions as $q) {
            $question = Question::create([
                'package_id' => $package->id,
                'category_id' => $twk->id,
                'question_text' => $q['text'],
                'order_number' => $order++,
            ]);

            foreach ($q['options'] as $opt) {
                Option::create([
                    'question_id' => $question->id,
                    'label' => $opt['label'],
                    'option_text' => $opt['text'],
                    'points' => $opt['points'],
                    'is_correct' => $opt['is_correct'],
                ]);
            }
        }

        // TIU Questions (2 sample)
        $tiuQuestions = [
            [
                'text' => 'Jika 2x + 5 = 15, maka nilai x adalah?',
                'options' => [
                    ['label' => 'A', 'text' => '3', 'points' => 0, 'is_correct' => false],
                    ['label' => 'B', 'text' => '4', 'points' => 0, 'is_correct' => false],
                    ['label' => 'C', 'text' => '5', 'points' => 5, 'is_correct' => true],
                    ['label' => 'D', 'text' => '6', 'points' => 0, 'is_correct' => false],
                    ['label' => 'E', 'text' => '7', 'points' => 0, 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Antonim dari kata "OPTIMIS" adalah?',
                'options' => [
                    ['label' => 'A', 'text' => 'Semangat', 'points' => 0, 'is_correct' => false],
                    ['label' => 'B', 'text' => 'Pesimis', 'points' => 5, 'is_correct' => true],
                    ['label' => 'C', 'text' => 'Gembira', 'points' => 0, 'is_correct' => false],
                    ['label' => 'D', 'text' => 'Berani', 'points' => 0, 'is_correct' => false],
                    ['label' => 'E', 'text' => 'Percaya diri', 'points' => 0, 'is_correct' => false],
                ],
            ],
        ];

        foreach ($tiuQuestions as $q) {
            $question = Question::create([
                'package_id' => $package->id,
                'category_id' => $tiu->id,
                'question_text' => $q['text'],
                'order_number' => $order++,
            ]);

            foreach ($q['options'] as $opt) {
                Option::create([
                    'question_id' => $question->id,
                    'label' => $opt['label'],
                    'option_text' => $opt['text'],
                    'points' => $opt['points'],
                    'is_correct' => $opt['is_correct'],
                ]);
            }
        }

        // TKP Question (1 sample)
        $tkpQuestion = [
            'text' => 'Anda melihat rekan kerja melakukan kesalahan yang dapat merugikan perusahaan. Apa yang akan Anda lakukan?',
            'options' => [
                ['label' => 'A', 'text' => 'Diam saja karena bukan urusan saya', 'points' => 1],
                ['label' => 'B', 'text' => 'Melaporkan langsung ke atasan', 'points' => 3],
                ['label' => 'C', 'text' => 'Membicarakan dengan rekan tersebut secara baik-baik', 'points' => 5],
                ['label' => 'D', 'text' => 'Menegur dengan keras di depan umum', 'points' => 2],
                ['label' => 'E', 'text' => 'Membicarakannya dengan rekan kerja lain', 'points' => 1],
            ],
        ];

        $question = Question::create([
            'package_id' => $package->id,
            'category_id' => $tkp->id,
            'question_text' => $tkpQuestion['text'],
            'order_number' => $order++,
        ]);

        foreach ($tkpQuestion['options'] as $opt) {
            Option::create([
                'question_id' => $question->id,
                'label' => $opt['label'],
                'option_text' => $opt['text'],
                'points' => $opt['points'],
                'is_correct' => false, // TKP doesn't have correct answer
            ]);
        }

        $this->command->info('Added ' . ($order - 1) . ' sample questions to SKD CPNS 2019!');
    }
}
