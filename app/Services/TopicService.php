<?php

namespace App\Services;

use App\Models\Topic;

final class TopicService
{
    protected $topic;

    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function create($validated)
    {
        $this->topic->create([
            'name' => $validated['name']
        ]);
    }

    public function update(Topic $topic, $validated)
    {
        $topic->update([
            'name' => $validated['name']
        ]);
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
    }
}
