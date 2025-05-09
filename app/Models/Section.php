<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'heading',
        'body'
    ];

    public function media() : MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
