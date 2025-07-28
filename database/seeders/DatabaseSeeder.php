<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            // Master data first
            RoleSeeder::class,
            MenuSeeder::class,
            ProdiSeeder::class,
            KeahlianSeeder::class,
            UserSeeder::class,
            UserMenuSeeder::class,
            DosenSeeder::class,

            // Judul and related data
            MstJudulSeeder::class,
            PengajuanJudulSeeder::class,
            MstJudulPembimbingSeeder::class,

            // Naive Bayes training data
            NaiveBayesSeeder::class,
        ]);
    }
}
