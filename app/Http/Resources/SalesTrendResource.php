<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesTrendResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'theater_id' => $this->theater_id,
            'theater_name' => $this->theater_name,
            'total_sales' => $this->total_sales,
        ];
    }
}
