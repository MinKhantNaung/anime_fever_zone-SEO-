<?php

namespace App\Services;

use App\Models\Topic;

final class TopicService
{
    public static function create($validated)
    {
        Topic::create([
            'name' => $validated['name']
        ]);
    }

    public static function update(Topic $topic, $validated)
    {
        $topic->update([
            'name' => $validated['name']
        ]);
    }
}
