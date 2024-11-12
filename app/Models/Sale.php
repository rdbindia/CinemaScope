<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'movie_theater_id',
        'sale_date',
        'sale_amount',
    ];

    public function movieTheater(): BelongsTo
    {
        return $this->belongsTo(MovieTheater::class, 'movie_theater_id');
    }
}
