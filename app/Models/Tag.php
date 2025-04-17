<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'body',
    ];

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
    public function findWithSlug($slug)
    {
        return $this->query()
            ->where('slug', $slug)
            ->with('media')
            ->first();
    }

    public function getTwoPerPage()
    {
        return $this->query()
            ->orderBy('id', 'desc')
            ->with('media')
            ->paginate(2);
    }

    public function getIdNamePairs()
    {
        return $this->query()
            ->select('id', 'name')
            ->pluck('name', 'id')
            ->toArray();
    }
}
