<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalesTrendResource;
use App\Http\Resources\TopSaleResource;
use App\Services\SalesService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function __construct(
        private readonly SalesService $salesService,
        private readonly Request $request
    )
    {
    }

    public function getTopSales(): JsonResponse
    {
        $this->request->validate([
            'date' => 'required|date',
        ]);

        $topTheater = $this->salesService->getTopSales();

        if ($topTheater->isEmpty()) {
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }

        return TopSaleResource::collection($topTheater)->additional([
            'success' => true,
        ])->response();
    }

    public function salesTrends(): JsonResponse
    {
        $this->request->validate([
            'start_date' => 'required|date',
        ]);

        $trends = $this->salesService->getTrendChart();

        return SalesTrendResource::collection($trends)->additional([
            'success' => true,
        ])->response()->setStatusCode(200);
    }
}
