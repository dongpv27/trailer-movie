<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'status',
        'view_count',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    public function pageVisits(): MorphMany
    {
        return $this->morphMany(PageVisit::class, 'visitable');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getUrlAttribute(): string
    {
        return route('post.show', $this->slug);
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : 'https://placehold.co/1200x630/1f2937/dc2626?text=TrailerPhim';
    }

    public function incrementView(): void
    {
        $lock = cache()->lock("post:{$this->id}:view", 10);

        if ($lock->get()) {
            try {
                $this->increment('view_count');
            } finally {
                $lock->release();
            }
        }
    }
}
