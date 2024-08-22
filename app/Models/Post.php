<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Usamamuneerchaudhary\Commentify\Traits\Commentable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory, Commentable;

    protected $guarded = [];

    protected $casts = [
        'is_publish' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = Str::slug($post->heading);
        });

        static::updating(function ($post) {
            $post->slug = Str::slug($post->heading);
        });
    }

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, PostTag::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    /** Database Logic */
    public function scopeFindPostWithSlug($query, $postSlug)
    {
        return $query->where('slug', $postSlug)
                    ->with('media', 'topic', 'tags', 'sections');
    }

    public function scopeFeaturedPosts($query)
    {
        return $query->where('is_publish', true)
                    ->where('is_feature', true)
                    ->orderBy('updated_at', 'desc')
                    ->with('media')
                    ->take(5);
    }

    public function scopeFeaturedPostsForPostPage($query, $postId)
    {
        return $query->where('id', '!=', $postId)
                    ->where('updated_at', '>=', Carbon::now()->subMonth())
                    ->where('is_publish', true)
                    ->inRandomOrder()
                    ->take(5);
    }

    public function scopeGetAll($query)
    {
        return $query->orderBy('id', 'desc')
                    ->with('media', 'topic', 'tags', 'sections');
    }

    public function scopeGetPublishedPosts($query)
    {
        return $query->where('is_publish', true)
                    ->orderBy('updated_at', 'desc')
                    ->with('media', 'topic', 'tags');
    }

    public function scopeGetPostsOfTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function ($q) use ($tagSlug) {
                        $q->where('slug', $tagSlug);
                    })
                    ->where('is_publish', true)
                    ->orderBy('updated_at', 'desc')
                    ->with('media', 'topic', 'tags');
    }

    public function scopeGetPostsOfTopic($query, $topicSlug)
    {
        return $query->whereHas('topic', function ($query) {
                        $query->where('slug', $this->slug);
                    })
                    ->where('is_publish', true)
                    ->orderBy('updated_at', 'desc')
                    ->with('media', 'topic', 'tags');
    }
}
