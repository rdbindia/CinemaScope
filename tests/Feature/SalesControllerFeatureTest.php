<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\MovieTheater;
use App\Models\Theater;
use App\Models\Sale;
use App\Services\SalesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use Carbon\Carbon;

class SalesControllerFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected SalesService|MockInterface $salesServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->salesServiceMock = Mockery::mock(SalesService::class);
    }

    public function testWhenDataExistForStartAndEndDateThenItReturnsDataSuccessfully()
    {
        $startDate = Carbon::parse('2024-11-01')->format('Y-m-d');
        $endDate = Carbon::parse('2024-12-09')->format('Y-m-d');

        $theater1 = Theater::factory()->create();
        $theater2 = Theater::factory()->create();

        $movie = Movie::factory()->create();

        $movieTheatre1 = MovieTheater::factory()->create([
            'movie_id' => $movie->id,
            'theater_id' => $theater1->id,
        ]);

        $movieTheatre2 = MovieTheater::factory()->create([
            'movie_id' => $movie->id,
            'theater_id' => $theater2->id,
        ]);

        Sale::factory()->create([
            'movie_theater_id' => $movieTheatre1->id,
            'sale_date' => '2024-11-01',
            'sale_amount' => 500,
        ]);

        Sale::factory()->create([
            'movie_theater_id' => $movieTheatre2->id,
            'sale_date' => '2024-11-11',
            'sale_amount' => 600,
        ]);

        $response = $this->getJson("/api/trends?start_date=$startDate&end_date=$endDate");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    [
                        'theater_id' => $theater1->id,
                        'theater_name' => $theater1->theater_name,
                        'total_sales' => 500,
                    ],
                    [
                        'theater_id' => $theater2->id,
                        'theater_name' => $theater2->theater_name,
                        'total_sales' => 600,
                    ],
                ],
            ]);
    }

    public function testWhenNoStartDataIsPassedThenValidationFails()
    {
        $response = $this->getJson('/api/trends');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['start_date']);
    }

    public function testWhenNoDataExistThenItReturnsEmptyData()
    {
        $date = Carbon::now()->format('Y-m-d');
        $this->salesServiceMock
            ->shouldReceive('getTopSales')
            ->andReturn(collect());

        $response = $this->getJson('/api/sale?date=' . $date);

        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
                'data' => [],
            ]);
    }
}
