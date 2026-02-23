<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bundle;
use App\Models\Package;

class BundleSeeder extends Seeder
{
    public function run(): void
    {
        // Get only paid packages (exclude free)
        $paidPackages = Package::where('is_free', false)->get();

        if ($paidPackages->count() < 2) {
            $this->command->warn('⚠️ Not enough packages to create bundles. Skipping...');
            return;
        }

        // Calculate bundle pricing
        $totalPrice = $paidPackages->sum('price');
        $discountPrice = $totalPrice * 0.65; // 35% discount

        $bundle = Bundle::updateOrCreate(
            ['slug' => 'bundle-paket-lengkap-semua'],
            [
                'name' => 'Bundle Paket Lengkap Semua Tahun',
                'slug' => 'bundle-paket-lengkap-semua',
                'description' => 'Dapatkan SEMUA paket simulasi SKD (2019, 2021, 2024, 2026) dengan harga spesial! Hemat hingga 35%.',
                'original_price' => $totalPrice,
                'discount_price' => $discountPrice,
                'is_active' => true,
            ]
        );

        // Attach all paid packages to bundle
        $bundle->packages()->sync($paidPackages->pluck('id'));

        $this->command->info('✅ Bundle seeded successfully!');
        $this->command->info("💰 Original: Rp " . number_format($totalPrice, 0, ',', '.'));
        $this->command->info("🎉 Bundle: Rp " . number_format($discountPrice, 0, ',', '.') . ' (35% OFF)');
    }
}
