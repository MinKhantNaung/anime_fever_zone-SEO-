<?php

namespace App\Observers;

use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

final class TagObserver
{
    public function created(Tag $tag)
    {
        Cache::forget('post.tags');
    }

    public function updated(Tag $tag)
    {
        Cache::forget('post.tags');
    }

    public function deleted(Tag $tag)
    {
        Cache::forget('post.tags');
    }
}
