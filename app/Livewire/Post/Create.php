<?php

namespace App\Livewire\Post;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Topic;
use App\Services\AlertService;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\PostService;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

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

    public function boot(Post $post, Topic $topic, Tag $tag, AlertService $alertService, FileService $fileService, MediaService $mediaService, PostService $postService)
    {
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

        DB::beginTransaction();
        try {
            $post = $this->postService->create($validated);

            $this->postService->attachTags($post, $this->selectedTags);

            // add media
            $url = $this->fileService->storeFile($this->media);

            // create media
            $this->mediaService->create(Post::class, $post, $url, 'image');

            DB::commit();

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('post-event');

            $this->alertService->alert($this, config('messages.post.create'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        $validated = $this->validate([
            'media' => ['required', 'file', 'mimes:png,jpg,jpeg,svg,webp', 'max:5120'],
            'topic_id' => ['required', 'integer', 'exists:topics,id'],
            'heading' => ['required', 'string', 'max:255', 'unique:posts,heading'],
            'body' => ['required', 'string'],
            'is_publish' => ['required', 'boolean'],
            'selectedTags' => ['nullable', 'array'],
            'selectedTags.*' => ['integer', 'exists:tags,id']
        ]);
        return $validated;
    }

    public function render()
    {
        $topics = $this->topic->getAllByName();
        $tags = $this->tag->getAllByName();

        return view('livewire.post.create', [
            'topics' => $topics,
            'tags' => $tags
        ]);
    }
}
