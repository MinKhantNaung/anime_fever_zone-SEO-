<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    protected $table = 'comment_likes';

    protected $fillable = [
        'user_id',
        'ip',
        'user_agent',
    ];

    public function scopeForIp($query, string $ip): mixed
    {
        return $query->where('ip', $ip);
    }

    public function scopeForUserAgent($query, string $userAgent): mixed
    {
        return $query->where('user_agent', $userAgent);
    }
}
