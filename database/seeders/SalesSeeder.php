<?php

namespace Database\Seeders;

use App\Models\MovieTheater;
use App\Models\Sale;
use App\Models\Theater;
use App\Traits\TruncateTable;
use Carbon\Carbon;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SalesSeeder extends Seeder
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

        $this->truncate('sales');

        Schema::enableForeignKeyConstraints();

        $movieTheaters = MovieTheater::all();

        foreach ($movieTheaters as $movieTheater) {
            Sale::create([
                'movie_theater_id' => $movieTheater->id,
                'sale_date' => Carbon::parse('2024-05-09'),
                'sale_amount' => rand(100, 1000),
            ]);

            Sale::create([
                'movie_theater_id' => $movieTheater->id,
                'sale_date' => Carbon::parse('2024-05-10'),
                'sale_amount' => rand(100, 1000),
            ]);
        }
    }
}
