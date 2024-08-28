<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Section;

final class SectionService
{
    protected $section;
    protected $mediaService;

    public function __construct(Section $section, MediaService $mediaService)
    {
        $this->section = $section;
        $this->mediaService = $mediaService;
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

    public function destroy(Section $section)
    {
        $medias = $section->media;
        $this->mediaService->destroyMultipleMedias($medias);
        $section->delete();
    }
}
