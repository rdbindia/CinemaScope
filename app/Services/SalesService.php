<?php

namespace App\Services;

use App\Models\Theater;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SalesService implements SalesServiceInterface
{
    public function __construct(
        private readonly Request $request,
    )
    {
    }

    public function getTopSales(): Collection
    {
        $date = $this->request->date;

        return Cache::remember("top_sales_{$date}", 60, function () use ($date) {
            return $this->queryTopSales($date);
        });
    }

    public function getTrendChart(): Collection
    {
        $carbonStartDate = Carbon::parse($this->request->start_date)->format('Y-m-d');
        $carbonEndDate = $this->request->end_date ? Carbon::parse($this->request->end_date)->format('Y-m-d') : Carbon::now();

        return Theater::with(['sales' => function ($query) use ($carbonStartDate, $carbonEndDate) {
            $query->whereBetween('sale_date', [$carbonStartDate, $carbonEndDate]);
        }])
            ->get()
            ->map(function ($theater) {
                $totalSales = $theater->sales->sum('sale_amount');

                return (object)[
                    'theater_id' => $theater->id,
                    'theater_name' => $theater->theater_name,
                    'total_sales' => $totalSales,
                ];
            });
    }

    private function queryTopSales($date): Collection
    {
        $carbonDate = Carbon::parse($date)->format('Y-m-d');

        return Theater::with(['sales' => function ($query) use ($carbonDate) {
            $query->where('sale_date', $carbonDate);
        }])
            ->get()
            ->map(function ($theater) {
                $totalSales = $theater->sales->sum('sale_amount');

                return (object)[
                    'theater_name' => $theater->theater_name,
                    'total_sales' => $totalSales,
                ];
            })->filter(function ($theater) {
                return $theater->total_sales > 0; // Only return theaters with sales on that date
            });
    }
}
