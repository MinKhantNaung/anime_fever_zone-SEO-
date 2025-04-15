<?php

namespace App\Observers;

use App\Models\Topic;
use Illuminate\Support\Facades\Cache;

final class TopicObserver
{
    public function created(Topic $topic)
    {
        Cache::forget('post.topics');
    }

    public function updated(Topic $topic)
    {
        Cache::forget('post.topics');
    }

    public function deleted(Topic $topic)
    {
        Cache::forget('post.topics');
    }
}
