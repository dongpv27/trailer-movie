<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrailerPlay extends Model
{
    protected $fillable = [
        'trailer_id',
        'movie_id',
        'session_id',
        'ip_address',
        'user_agent',
        'played_at',
    ];

    protected $casts = [
        'played_at' => 'datetime',
    ];

    public $timestamps = false;

    public function trailer(): BelongsTo
    {
        return $this->belongsTo(Trailer::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
