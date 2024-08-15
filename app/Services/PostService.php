<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    public static function create($validated)
    {
        $post = Post::create([
            'topic_id' => $validated['topic_id'],
            'heading' => $validated['heading'],
            'body' => $validated['body'],
            'is_publish' => $validated['is_publish']
        ]);

        return $post;
    }

    public static function update($post, $validated)
    {
        $post->update([
            'topic_id' => $validated['topic_id'],
            'heading' => $validated['heading'],
            'body' => $validated['body'],
            'is_publish' => $validated['is_publish']
        ]);
    }

    public static function attachTags($postModel, $selectedTags)
    {
        if ($selectedTags != null) {
            $postModel->tags()->attach($selectedTags);
        }
    }
}
