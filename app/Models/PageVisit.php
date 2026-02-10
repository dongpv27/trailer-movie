<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PageVisit extends Model
{
    protected $fillable = [
        'url',
        'route_name',
        'visitable_type',
        'visitable_id',
        'session_id',
        'ip_address',
        'user_agent',
        'referer',
        'metadata',
        'visited_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'visited_at' => 'datetime',
    ];

    public $timestamps = false;

    public function visitable(): MorphTo
    {
        return $this->morphTo();
    }
}
