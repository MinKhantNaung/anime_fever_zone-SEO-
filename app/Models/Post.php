<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Commentable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Post extends Model
{
    use HasFactory, Commentable;

    protected $fillable = [
        'topic_id',
        'heading',
        'slug',
        'body',
        'is_feature',
        'is_publish'
    ];

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
    public function scopePublished($query)
    {
        return $query->where('is_publish', true);
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function scopeIsFeature($query)
    {
        return $query->where('is_feature', true);
    }

    public function scopeNotThisPost($query, $postId)
    {
        return $query->where('id', '!=', $postId);
    }

    public function scopeInLastMonth($query)
    {
        return $query->where('updated_at', '>=', Carbon::now()->subMonth());
    }

    public function findPostWithSlug($postSlug)
    {
        return $this->query()
            ->slug($postSlug)
            ->with('media', 'topic', 'tags', 'sections')
            ->first();
    }

    public function getFeaturedPosts()
    {
        return $this->query()
            ->published()
            ->isFeature()
            ->with('media')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
    }

    public function featuredPostsForPostPage($postId)
    {
        return $this->query()
            ->notThisPost($postId)
            ->inLastMonth()
            ->published()
            ->with('media')
            ->inRandomOrder()
            ->take(5)
            ->get();
    }

    public function getFivePerPage()
    {
        return $this->query()
            ->orderBy('id', 'desc')
            ->with('media', 'topic', 'tags', 'sections')
            ->paginate(5);
    }

    public function getPublishedPosts()
    {
        return $this->query()
            ->published()
            ->with('media', 'topic', 'tags')
            ->paginate(12);
    }

    public function getPostsOfTag($tagSlug)
    {
        return $this->query()
            ->whereHas('tags', function ($q) use ($tagSlug) {
                $q->slug($tagSlug);
            })
            ->published()
            ->with('media', 'topic', 'tags')
            ->paginate(12);
    }

    public function getPostsOfTopic($topicSlug)
    {
        return $this->query()
            ->whereHas('topic', function ($q) use ($topicSlug) {
                $q->slug($topicSlug);
            })
            ->published()
            ->with('media', 'topic', 'tags')
            ->paginate(12);
    }
}
