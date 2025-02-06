<?php

namespace App\Models;

use App\Traits\HasLikes;
use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Presenters\CommentPresenter;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, HasLikes;

    protected $table = 'comments';

    protected $fillable = ['body'];

    protected $withCount = [
        'likes',
    ];

    public function presenter(): CommentPresenter
    {
        return new CommentPresenter($this);
    }

    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->oldest();
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    // Database Logic
    public function scopeParent($query): void
    {
        $query->whereNull('parent_id');
    }

    protected static function newFactory(): CommentFactory
    {
        return CommentFactory::new();
    }
}
