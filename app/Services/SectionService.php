<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Section;

final class SectionService
{
    public static function create(Post $post, $validated)
    {
        $section = Section::create([
            'post_id' => $post->id,
            'heading' => $validated['heading'],
            'body' => $validated['body']
        ]);

        return $section;
    }

    public static function update(Section $section, $validated)
    {
        $section->update([
            'heading' => $validated['heading'],
            'body' => $validated['body']
        ]);
    }
}
