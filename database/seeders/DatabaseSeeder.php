<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            PackageSeeder::class,
            BundleSeeder::class,
            AdminSeeder::class,
            // Uncomment to seed sample questions (takes time)
            // SampleQuestionSeeder::class,
        ]);
    }
}
