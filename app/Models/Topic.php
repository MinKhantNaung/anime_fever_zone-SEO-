<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($topic) {
            $topic->slug = Str::slug($topic->name);
        });

        static::updating(function ($topic) {
            $topic->slug = Str::slug($topic->name);
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /** Database Logic */
    public function getAllByName()
    {
        return $this->query()
            ->select('id', 'name', 'slug')
            ->get();
    }

    public function getIdNamePairs()
    {
        return $this->query()
            ->select('id', 'name')
            ->pluck('name', 'id')
            ->toArray();
    }
}
