<?php

namespace Database\Seeders;

use App\Models\Bundle;
use App\Models\Package;
use Illuminate\Database\Seeder;

class BundleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create bundle with all packages
        $bundle = Bundle::updateOrCreate(
            ['slug' => 'bundle-all-packages'],
            [
                'name' => 'Bundle Lengkap Semua Paket',
                'description' => 'Akses semua paket simulasi SKD CPNS (2019, 2021, 2023, 2024, dan Prediksi 2026) dengan harga diskon 30%.',
                'original_price' => 180000, // Sum of all package prices
                'discount_price' => 126000, // 30% discount
                'is_active' => true,
            ]
        );

        // Attach all active packages to bundle
        $packageIds = Package::active()->pluck('id')->toArray();
        $bundle->packages()->sync($packageIds);
    }
}
