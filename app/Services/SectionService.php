<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Section;

final class SectionService
{
    protected $section;

    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    public function create(Post $post, $validated)
    {
        $section = $this->section->create([
            'post_id' => $post->id,
            'heading' => $validated['heading'],
            'body' => $validated['body']
        ]);

        return $section;
    }

    public function update(Section $section, $validated)
    {
        $section->update([
            'heading' => $validated['heading'],
            'body' => $validated['body']
        ]);
    }
}
