<?php

namespace App\Services;

use App\Models\Post;

final class PostService
{
    protected $post;
    protected $mediaService;
    protected $sectionService;

    public function __construct(Post $post, MediaService $mediaService, SectionService $sectionService)
    {
        $this->post = $post;
        $this->mediaService = $mediaService;
        $this->sectionService = $sectionService;
    }

    public function create($validated)
    {
        $post = $this->post->create([
            'topic_id' => $validated['topic_id'],
            'heading' => $validated['heading'],
            'body' => $validated['body'],
            'is_publish' => $validated['is_publish']
        ]);

        return $post;
    }

    public function update($post, $validated)
    {
        $post->update([
            'topic_id' => $validated['topic_id'],
            'heading' => $validated['heading'],
            'body' => $validated['body'],
            'is_publish' => $validated['is_publish']
        ]);
    }

    public function attachTags($postModel, $selectedTags)
    {
        if ($selectedTags != null) {
            $postModel->tags()->attach($selectedTags);
        }
    }

    public function toggleIsFeature(Post $post)
    {
        $post->update([
            'is_feature' => !$post->is_feature
        ]);
    }

    public function destroy(Post $post)
    {
        // delete related media
        $media = $post->media;
        if ($media) {
            $this->mediaService->destroy($media);
        }

        // delete its sections
        $sections = $post->sections;

        foreach ($sections as $section) {
            // delete section
            $this->sectionService->destroy($section);
        }

        // Remove relationships between post and associated tags
        $post->tags()->detach();

        $post->delete();
    }
}
