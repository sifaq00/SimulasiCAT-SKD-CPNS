<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Option;
use App\Models\Package;
use App\Models\Question;
use Illuminate\Database\Seeder;

class SampleQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $package = Package::where('year', 2024)->first();
        
        if (!$package) {
            $this->command->error('Package 2024 tidak ditemukan!');
            return;
        }

        $twk = Category::where('code', 'TWK')->first();
        $tiu = Category::where('code', 'TIU')->first();
        $tkp = Category::where('code', 'TKP')->first();

        // ===== SOAL 1: TWK (Wawasan Kebangsaan) =====
        $q1 = Question::create([
            'package_id' => $package->id,
            'category_id' => $twk->id,
            'question_text' => 'Pancasila sebagai dasar negara Indonesia pertama kali dirumuskan dalam pidato yang dikenal sebagai...',
            'explanation' => 'Pidato Ir. Soekarno pada tanggal 1 Juni 1945 di depan sidang BPUPKI dikenal sebagai pidato "Lahirnya Pancasila". Dalam pidato tersebut, Soekarno mengusulkan lima dasar negara yang kemudian menjadi Pancasila.',
            'order_number' => 1,
        ]);

        $options1 = [
            ['label' => 'A', 'option_text' => 'Pidato Proklamasi', 'points' => 0, 'is_correct' => false],
            ['label' => 'B', 'option_text' => 'Pidato Lahirnya Pancasila', 'points' => 5, 'is_correct' => true],
            ['label' => 'C', 'option_text' => 'Pidato Kemerdekaan', 'points' => 0, 'is_correct' => false],
            ['label' => 'D', 'option_text' => 'Pidato Supersemar', 'points' => 0, 'is_correct' => false],
            ['label' => 'E', 'option_text' => 'Pidato Tritura', 'points' => 0, 'is_correct' => false],
        ];

        $correctOptionId = null;
        foreach ($options1 as $opt) {
            $option = Option::create(array_merge($opt, ['question_id' => $q1->id]));
            if ($opt['is_correct']) {
                $correctOptionId = $option->id;
            }
        }
        $q1->update(['correct_option_id' => $correctOptionId]);

        // ===== SOAL 2: TIU (Tes Intelegensia Umum) =====
        $q2 = Question::create([
            'package_id' => $package->id,
            'category_id' => $tiu->id,
            'question_text' => 'Jika 3x + 7 = 22, maka nilai x adalah...',
            'explanation' => 'Penyelesaian: 3x + 7 = 22 → 3x = 22 - 7 → 3x = 15 → x = 15/3 → x = 5',
            'order_number' => 1,
        ]);

        $options2 = [
            ['label' => 'A', 'option_text' => '3', 'points' => 0, 'is_correct' => false],
            ['label' => 'B', 'option_text' => '4', 'points' => 0, 'is_correct' => false],
            ['label' => 'C', 'option_text' => '5', 'points' => 5, 'is_correct' => true],
            ['label' => 'D', 'option_text' => '6', 'points' => 0, 'is_correct' => false],
            ['label' => 'E', 'option_text' => '7', 'points' => 0, 'is_correct' => false],
        ];

        $correctOptionId = null;
        foreach ($options2 as $opt) {
            $option = Option::create(array_merge($opt, ['question_id' => $q2->id]));
            if ($opt['is_correct']) {
                $correctOptionId = $option->id;
            }
        }
        $q2->update(['correct_option_id' => $correctOptionId]);

        // ===== SOAL 3: TKP (Tes Karakteristik Pribadi) =====
        $q3 = Question::create([
            'package_id' => $package->id,
            'category_id' => $tkp->id,
            'question_text' => 'Anda diminta atasan untuk menyelesaikan tugas yang sangat mendesak, padahal Anda sudah memiliki jadwal rapat penting dengan tim. Apa yang akan Anda lakukan?',
            'explanation' => 'Soal TKP menilai kemampuan manajemen prioritas dan komunikasi. Pilihan terbaik adalah yang menunjukkan profesionalisme, komunikasi yang baik, dan tanggung jawab.',
            'order_number' => 1,
        ]);

        // TKP: Setiap opsi punya poin berbeda (1-5)
        $options3 = [
            ['label' => 'A', 'option_text' => 'Menolak tugas dari atasan karena sudah ada jadwal rapat', 'points' => 1, 'is_correct' => false],
            ['label' => 'B', 'option_text' => 'Mengabaikan rapat dan fokus pada tugas atasan', 'points' => 2, 'is_correct' => false],
            ['label' => 'C', 'option_text' => 'Meminta rekan kerja untuk menggantikan di rapat, lalu mengerjakan tugas', 'points' => 4, 'is_correct' => false],
            ['label' => 'D', 'option_text' => 'Berkomunikasi dengan atasan tentang jadwal rapat, dan bernegosiasi deadline tugas', 'points' => 5, 'is_correct' => false],
            ['label' => 'E', 'option_text' => 'Mengerjakan keduanya secara bersamaan', 'points' => 3, 'is_correct' => false],
        ];

        foreach ($options3 as $opt) {
            Option::create(array_merge($opt, ['question_id' => $q3->id]));
        }

        $this->command->info('✅ 3 soal contoh berhasil ditambahkan!');
    }
}
