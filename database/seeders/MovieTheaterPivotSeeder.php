<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\MovieTheater;
use App\Models\Theater;
use App\Traits\TruncateTable;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MovieTheaterPivotSeeder extends Seeder
{
    use TruncateTable;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->truncate('movie_theater_pivot');

        Schema::enableForeignKeyConstraints();

        $movieIds = Movie::pluck('id')->toArray();
        $theaterIds = Theater::pluck('id')->toArray();

        foreach ($movieIds as $movieId) {
            foreach ($theaterIds as $theaterId) {
                if (rand(0, 100) < 20) {
                    continue;
                }

                MovieTheater::firstOrCreate([
                    'movie_id' => $movieId,
                    'theater_id' => $theaterId,
                ]);
            }
        }
    }
}
