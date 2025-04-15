<?php

namespace App\Livewire\Post;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Topic;
use App\Services\FileService;
use App\Services\PostService;
use Livewire\WithFileUploads;
use App\Services\AlertService;
use App\Services\MediaService;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Cache;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $media;
    public $topic_id;
    public $heading;
    public $body;
    public $is_publish = false;
    public $selectedTags = null;

    // Models, Services
    protected $post;
    protected $topic;
    protected $tag;
    protected $alertService;
    protected $fileService;
    protected $mediaService;
    protected $postService;

    public function boot(
        Post $post,
        Topic $topic,
        Tag $tag,
        AlertService $alertService,
        FileService $fileService,
        MediaService $mediaService,
        PostService $postService
    ) {
        $this->post = $post;
        $this->topic = $topic;
        $this->tag = $tag;
        $this->alertService = $alertService;
        $this->fileService = $fileService;
        $this->mediaService = $mediaService;
        $this->postService = $postService;
    }

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function createPost()
    {
        $validated = $this->validateInputs();

        try {
            DB::transaction(function () use ($validated) {
                $post = $this->postService->create($validated);

                $this->postService->attachTags($post, $this->selectedTags);

                $url = $this->fileService->storeFile($this->media);

                $this->mediaService->create(Post::class, $post, $url, 'image');
            });

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('post-event');

            $this->alertService->alert($this, config('messages.post.create'), 'success');
        } catch (\Throwable $e) {
            logger()->error('Failed to create post', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        return $this->validate([
            'media' => ['required', 'file', 'mimes:png,jpg,jpeg,webp', 'max:5120'],
            'topic_id' => ['required', 'integer', 'exists:topics,id'],
            'heading' => ['required', 'string', 'max:255', 'unique:posts,heading'],
            'body' => ['required', 'string'],
            'is_publish' => ['required', 'boolean'],
            'selectedTags' => ['nullable', 'array'],
            'selectedTags.*' => ['integer', 'exists:tags,id']
        ]);
    }

    public function render()
    {
        $topics = Cache::flexible('post.topics', [5, 10], function () {
            return $this->topic->getIdNamePairs();
        });

        $tags = Cache::flexible('post.tags', [5, 10], function () {
            return $this->tag->getIdNamePairs();
        });

        return view('livewire.post.create', [
            'topics' => $topics,
            'tags' => $tags
        ]);
    }
}
