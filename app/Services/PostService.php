<?php

namespace App\Services;

use App\Models\Post;

final class PostService
{
    public function __construct(
        private Post $post,
        private MediaService $mediaService,
        private SectionService $sectionService
    ) {}

    public function create(array $attributes): Post
    {
        return $this->post->create([
            'topic_id' => $attributes['topic_id'],
            'heading' => $attributes['heading'],
            'body' => $attributes['body'],
            'is_publish' => $attributes['is_publish']
        ]);
    }

    public function update(Post $post, array $attributes): void
    {
        $post->update([
            'topic_id' => $attributes['topic_id'],
            'heading' => $attributes['heading'],
            'body' => $attributes['body'],
            'is_publish' => $attributes['is_publish']
        ]);
    }

    public function attachTags(Post $post, array $selectedTags = []): void
    {
        if (!empty($selectedTags)) {
            $post->tags()->attach($selectedTags);
        }
    }

    public function toggleIsFeature(Post $post): void
    {
        $post->update([
            'is_feature' => !$post->is_feature
        ]);
    }

    public function destroy(Post $post): void
    {
        $post->load(['media', 'sections.media', 'tags']);

        // delete related media
        $media = $post->media;
        if ($media) {
            $this->mediaService->destroy($media);
        }

        // delete its sections
        foreach ($post->sections as $section) {
            $this->sectionService->destroy($section);
        }

        // Detach associated tags
        $post->tags()->detach();

        $post->delete();
    }
}
