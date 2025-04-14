<?php

namespace App\Services;

use App\Models\Topic;

final class TopicService
{
    public function __construct(private Topic $topic) {}

    public function create(array $attributes): void
    {
        $this->topic->create([
            'name' => $attributes['name']
        ]);
    }

    public function update(Topic $topic, array $attributes): void
    {
        $topic->update([
            'name' => $attributes['name']
        ]);
    }

    public function destroy(Topic $topic): void
    {
        $topic->delete();
    }
}
