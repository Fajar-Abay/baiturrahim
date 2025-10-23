<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\PengurusSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Jalankan seeder lain
        $this->call([
            // PengurusSeeder::class,
            // GaleriSeeder::class,
            // PenghargaanSeeder::class,
            UserSeeder::class
        ]);
    }
}
