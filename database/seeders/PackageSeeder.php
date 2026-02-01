<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Simulasi SKD CPNS 2019',
                'slug' => 'skd-cpns-2019',
                'description' => 'Simulasi soal SKD CPNS berdasarkan tes tahun 2019. Berisi 110 soal dengan durasi 100 menit.',
                'year' => 2019,
                'price' => 25000,
                'total_questions' => 110,
                'duration_minutes' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Simulasi SKD CPNS 2021',
                'slug' => 'skd-cpns-2021',
                'description' => 'Simulasi soal SKD CPNS berdasarkan tes tahun 2021. Berisi 110 soal dengan durasi 100 menit.',
                'year' => 2021,
                'price' => 30000,
                'total_questions' => 110,
                'duration_minutes' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Simulasi SKD CPNS 2023',
                'slug' => 'skd-cpns-2023',
                'description' => 'Simulasi soal SKD CPNS berdasarkan tes tahun 2023. Berisi 110 soal dengan durasi 100 menit.',
                'year' => 2023,
                'price' => 35000,
                'total_questions' => 110,
                'duration_minutes' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Simulasi SKD CPNS 2024',
                'slug' => 'skd-cpns-2024',
                'description' => 'Simulasi soal SKD CPNS berdasarkan tes tahun 2024. Berisi 110 soal dengan durasi 100 menit.',
                'year' => 2024,
                'price' => 40000,
                'total_questions' => 110,
                'duration_minutes' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Simulasi SKD CPNS 2026 (Prediksi)',
                'slug' => 'skd-cpns-2026-prediksi',
                'description' => 'Simulasi soal prediksi SKD CPNS tahun 2026. Berisi 110 soal dengan durasi 100 menit.',
                'year' => 2026,
                'price' => 50000,
                'total_questions' => 110,
                'duration_minutes' => 100,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['slug' => $package['slug']],
                $package
            );
        }
    }
}
