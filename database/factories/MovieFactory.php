<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movie>
 */
class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition(): array
    {
        return [
            'movie_title' => $this->faker->streetName(),
            'release_date' => $this->faker->dateTimeThisYear()->format('Y-m-d'),
        ];
    }
}
