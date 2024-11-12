<?php

namespace Database\Seeders;

use App\Models\MovieTheater;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MoviesSeeder::class,
            TheatersSeeder::class,
            MovieTheaterPivotSeeder::class,
            SalesSeeder::class,
        ]);
    }
}
