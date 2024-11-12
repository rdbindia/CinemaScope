<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';

    protected $fillable = [
        'movie_title',
        'release_date',
    ];

    public function theaters(): BelongsToMany
    {
        return $this->belongsToMany(MovieTheater::class);
    }
}
