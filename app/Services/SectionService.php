<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Section;

final class SectionService
{
    public function __construct(
        private Section $section,
        private MediaService $mediaService
    ) {}

    public function create(Post $post, array $attributes): Section
    {
        return $this->section->create([
            'post_id' => $post->id,
            'heading' => $attributes['heading'],
            'body' => $attributes['body']
        ]);
    }

    public function update(Section $section, array $attributes): void
    {
        $section->update([
            'heading' => $attributes['heading'],
            'body' => $attributes['body']
        ]);
    }

    public function destroy(Section $section): void
    {
        $medias = $section->media;
        $this->mediaService->destroyMultipleMedias($medias);
        $section->delete();
    }
}
