<?php

namespace App\Livewire\Post;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Topic;
use App\Services\AlertService;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\PostService;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    use WithFileUploads;

    public $media;
    public $topic_id;
    public $heading;
    public $body;
    public $is_publish = false;
    public $selectedTags = null;
    public Post $post;

    protected $tag;
    protected $topic;
    protected $alertService;
    protected $fileService;
    protected $mediaService;
    protected $postService;

    public function boot(
        Tag $tag,
        Topic $topic,
        AlertService $alertService,
        FileService $fileService,
        MediaService $mediaService,
        PostService $postService
    ) {
        $this->tag = $tag;
        $this->topic = $topic;
        $this->alertService = $alertService;
        $this->fileService = $fileService;
        $this->mediaService = $mediaService;
        $this->postService = $postService;
    }

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function mount()
    {
        $this->topic_id = $this->post->topic_id;
        $this->heading = $this->post->heading;
        $this->body = $this->post->body;
        $this->is_publish = $this->post->is_publish;
        $this->selectedTags = $this->post->tags()->pluck('tags.id')->toArray();
    }

    public function updatePost()
    {
        $validated = $this->validateInputs();

        try {
            DB::transaction(function () use ($validated) {
                $this->postService->update($this->post, $validated);

                $this->post->tags()->detach();
                $this->postService->attachTags($this->post, $this->selectedTags);

                if ($validated['media']) {
                    $this->updateMedia($validated['media']);
                }
            });

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('post-event');

            $this->alertService->alert($this, config('messages.post.update'), 'success');
        } catch (\Throwable $e) {
            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        return $this->validate([
            'media' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:5120'],
            'topic_id' => ['required', 'integer', 'exists:topics,id'],
            'heading' => ['required', 'string', 'max:255', 'unique:posts,heading,' . $this->post->id],
            'body' => ['required', 'string'],
            'is_publish' => ['required', 'boolean'],
            'selectedTags' => ['nullable', 'array'],
            'selectedTags.*' => ['integer', 'exists:tags,id']
        ]);
    }

    protected function updateMedia($newMedia)
    {
        // delete previous media
        $media = $this->post->media;

        if ($media) {
            $this->mediaService->destroy($media);
        }

        // add updated media
        $url = $this->fileService->storeFile($newMedia);

        $this->mediaService->create(Post::class, $this->post, $url, 'image');
    }

    public function render()
    {
        $topics = $this->topic->getAllByName();
        $tags = $this->tag->getAllByName();

        return view('livewire.post.edit', [
            'topics' => $topics,
            'tags' => $tags
        ]);
    }
}
