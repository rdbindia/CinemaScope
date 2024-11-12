<?php

namespace Database\Factories;

use App\Models\Theater;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Theater>
 */
class TheaterFactory extends Factory
{
    protected $model = Theater::class;
    public function definition(): array
    {
        return [
            'theater_name' => $this->faker->streetName(),
            'location' => $this->faker->streetAddress(),
        ];
    }
}
