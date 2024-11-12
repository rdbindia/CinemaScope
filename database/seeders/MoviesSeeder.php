<?php

namespace Database\Seeders;

use App\Models\Movie;


use App\Traits\TruncateTable;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MoviesSeeder extends Seeder
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

        $this->truncate('movies');

        Schema::enableForeignKeyConstraints();

       Movie::factory()->count(2)->create();
    }
}
