<?php

namespace Database\Factories;

use App\Models\MovieTheater;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        return [
            'movie_theater_id' => MovieTheater::inRandomOrder()->first()->id,
            'sale_date' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'), // Random date within the last 30 days
            'sale_amount' => $this->faker->numberBetween(100, 1000), // Random sales amount between 100 and 1000
        ];
    }
}
