<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\MovieTheater;
use App\Models\Theater;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends Factory<MovieTheater>
 */
class MovieTheaterFactory extends Factory
{
    protected $model = MovieTheater::class;

    public function definition(): array
    {
        return [
            'movie_id' => DB::table('movies')->inRandomOrder()->value('id'),
            'theater_id' => DB::table('theaters')->inRandomOrder()->value('id'),
        ];
    }
}
