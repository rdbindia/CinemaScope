<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface SalesServiceInterface
{
    public function getTopSales(): Collection;
}
