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
    public function findPostWithSlug($postSlug)
    {
        return $this->query()
                    ->where('slug', $postSlug)
                    ->with('media', 'topic', 'tags', 'sections')
                    ->first();
    }

    public function getFeaturedPosts()
    {
        return $this->query()
                    ->where('is_publish', true)
                    ->where('is_feature', true)
                    ->orderBy('updated_at', 'desc')
                    ->with('media')
                    ->take(5)
                    ->get();
    }

    public function featuredPostsForPostPage($postId)
    {
        return $this->query()
                    ->where('id', '!=', $postId)
                    ->where('updated_at', '>=', Carbon::now()->subMonth())
                    ->where('is_publish', true)
                    ->inRandomOrder()
                    ->take(5)
                    ->get();
    }

    public function getAllPerFive()
    {
        return $this->query()
                    ->orderBy('id', 'desc')
                    ->with('media', 'topic', 'tags', 'sections')
                    ->paginate(5);
    }

    public function getPublishedPosts()
    {
        return $this->query()
                    ->where('is_publish', true)
                    ->orderBy('updated_at', 'desc')
                    ->with('media', 'topic', 'tags')
                    ->paginate(12);
    }

    public function getPostsOfTag($tagSlug)
    {
        return $this->query()
                    ->whereHas('tags', function ($q) use ($tagSlug) {
                        $q->where('slug', $tagSlug);
                    })
                    ->where('is_publish', true)
                    ->orderBy('updated_at', 'desc')
                    ->with('media', 'topic', 'tags')
                    ->paginate(12);
    }

    public function getPostsOfTopic($topicSlug)
    {
        return $this->query()
                    ->whereHas('topic', function ($query) {
                        $query->where('slug', $this->slug);
                    })
                    ->where('is_publish', true)
                    ->orderBy('updated_at', 'desc')
                    ->with('media', 'topic', 'tags')
                    ->paginate(12);
    }
}
