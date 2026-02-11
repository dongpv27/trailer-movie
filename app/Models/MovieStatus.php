<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieStatus extends Model
{
    protected $fillable = ['movie_id', 'status'];

    protected $casts = [
        'status' => 'string',
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
