<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;

/**
 *
 * @property int $id
 * @property string $theater_name
 * @property string $location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class Theater extends Model
{
    use HasFactory;

    protected $table = 'theaters';

    protected $fillable = [
        'theater_name',
        'location',
    ];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, MovieTheater::class);
    }

    public function sales(): HasManyThrough
    {
        return $this->hasManyThrough(Sale::class, MovieTheater::class, 'theater_id', 'movie_theater_id', 'id', 'id');
    }
}
