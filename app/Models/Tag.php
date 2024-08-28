<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            $tag->slug = Str::slug($tag->name);
        });

        static::updating(function ($tag) {
            $tag->slug = Str::slug($tag->name);
        });
    }

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, PostTag::class);
    }

    /** Database Logic */
    public function scopeFindWithSlug($query, $slug)
    {
        return $query->where('slug', $slug)
                    ->with('media');
    }

    public function scopeGetAll($query)
    {
        return $query->orderBy('id', 'desc')
                    ->with('media');
    }

    public function getAllByName()
    {
        return $this->query()
                    ->select('id', 'name')
                    ->get();
    }
}
