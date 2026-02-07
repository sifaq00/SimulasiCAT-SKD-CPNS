<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Latihan Gratis SKD 2026',
                'slug' => 'latihan-gratis-skd-2026',
                'description' => 'Paket latihan gratis untuk mencoba sistem simulasi SKD CPNS kami',
                'year' => 2026,
                'price' => 0,
                'bundle_price' => null,
                'total_questions' => 110,
                'duration_minutes' => 100,
                'is_active' => true,
                'is_free' => true,
            ],
            [
                'name' => 'Paket Simulasi SKD CPNS 2019',
                'slug' => 'skd-cpns-2019',
                'description' => 'Paket simulasi tes SKD CPNS 2019 dengan soal-soal tahun sebelumnya',
                'year' => 2019,
                'price' => 15000,
                'bundle_price' => null,
                'total_questions' => 110,
                'duration_minutes' => 100,
                'is_active' => true,
                'is_free' => false,
            ],
            [
                'name' => 'Paket Simulasi SKD CPNS 2021',
                'slug' => 'skd-cpns-2021',
                'description' => 'Paket simulasi tes SKD CPNS 2021 dengan model soal terkini',
                'year' => 2021,
                'price' => 20000,
                'bundle_price' => null,
                'total_questions' => 110,
                'duration_minutes' => 100,
                'is_active' => true,
                'is_free' => false,
            ],
            [
                'name' => 'Paket Simulasi SKD CPNS 2024',
                'slug' => 'skd-cpns-2024',
                'description' => 'Paket simulasi lengkap tes SKD CPNS 2024 dengan model soal terkini dan pembahasan detail',
                'year' => 2024,
                'price' => 30000,
                'bundle_price' => null,
                'total_questions' => 110,
                'duration_minutes' => 100,
                'is_active' => true,
                'is_free' => false,
            ],
            [
                'name' => 'Paket Simulasi SKD CPNS 2026 (Prediksi)',
                'slug' => 'skd-cpns-2026-prediksi',
                'description' => 'Paket simulasi tes SKD CPNS 2026 dengan prediksi soal berdasarkan tren terbaru',
                'year' => 2026,
                'price' => 40000,
                'bundle_price' => null,
                'total_questions' => 110,
                'duration_minutes' => 100,
                'is_active' => true,
                'is_free' => false,
            ],
        ];

        foreach ($packages as $packageData) {
            Package::updateOrCreate(
                ['slug' => $packageData['slug']],
                $packageData
            );
        }

        $this->command->info('✅ Packages seeded successfully!');
        $this->command->info('📦 5 packages created: 1 free + 4 paid');
    }
}
