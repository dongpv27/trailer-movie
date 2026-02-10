<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
    ];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }

    public function pageVisits(): MorphMany
    {
        return $this->morphMany(PageVisit::class, 'visitable');
    }

    public function scopeGenres($query)
    {
        return $query->where('type', 'genre');
    }

    public function scopeCountries($query)
    {
        return $query->where('type', 'country');
    }

    public function scopeYears($query)
    {
        return $query->where('type', 'year');
    }

    public function getUrlAttribute(): string
    {
        return match($this->type) {
            'genre' => route('category.genre', $this->slug),
            'country' => route('category.country', $this->slug),
            'year' => route('category.year', $this->slug),
            default => '/',
        };
    }
}
