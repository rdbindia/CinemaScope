<?php

namespace Tests\Unit;


use App\Http\Controllers\SalesController;
use App\Services\SalesService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;
use Carbon\Carbon;

class SalesControllerTest extends TestCase
{
    protected SalesService $salesServiceMock;
    protected SalesController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->salesServiceMock = Mockery::mock(SalesService::class);
    }

    public function testGetTopSalesReturnsEmptyData()
    {
        $date = Carbon::now()->format('Y-m-d');

        $this->salesServiceMock
            ->shouldReceive('getTopSales')
            ->once()
            ->andReturn(collect());

        $request = new Request(['date' => $date]);
        $this->controller = new SalesController($this->salesServiceMock, $request);

        $response = $this->controller->getTopSales();


        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);

        $this->assertFalse($responseData['success']);
        $this->assertEquals([], $responseData['data']);
    }

    public function testSalesTrendsReturnsEmptyData()
    {
        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->addDay()->format('Y-m-d');

        $this->salesServiceMock
            ->shouldReceive('getTrendChart')
            ->once()
            ->andReturn(collect());

        $request = new Request(['start_date' => $startDate, 'end_date' => $endDate]);
        $this->controller = new SalesController($this->salesServiceMock, $request);

        $response = $this->controller->salesTrends();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);

        $this->assertTrue($responseData['success']);
        $this->assertEquals([], $responseData['data']);
    }

    public function testSalesTrendsReturnsDataSuccessfully()
    {
        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->addDay()->format('Y-m-d');

        $this->salesServiceMock
            ->shouldReceive('getTrendChart')
            ->once()
            ->andReturn(collect([
                (object)['theater_id' => 1, 'theater_name' => 'Theater 1', 'total_sales' => 500],
                (object)['theater_id' => 2, 'theater_name' => 'Theater 2', 'total_sales' => 600],
            ]));

        $request = new Request(['start_date' => $startDate, 'end_date' => $endDate]);
        $this->controller = new SalesController($this->salesServiceMock, $request);

        $response = $this->controller->salesTrends();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);

        $this->assertTrue($responseData['success']);
        $this->assertEquals([
            ['theater_id' => 1, 'theater_name' => 'Theater 1', 'total_sales' => 500],
            ['theater_id' => 2, 'theater_name' => 'Theater 2', 'total_sales' => 600],
        ], $responseData['data']);
    }
}
