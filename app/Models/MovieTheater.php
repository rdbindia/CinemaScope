<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MovieTheater extends Model
{
    use HasFactory;

    protected $table = 'movie_theater_pivot';

    protected $fillable = [
        'movie_id',
        'theater_id',
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::class, 'theater_id');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'movie_theater_id');
    }
}
