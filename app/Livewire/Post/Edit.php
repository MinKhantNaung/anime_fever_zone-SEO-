<?php

namespace App\Livewire\Post;

use App\Models\Media;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Topic;
use App\Services\AlertService;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\PostService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        // validate
        $validated = $this->validateInputs();

        DB::beginTransaction();

        try {
            PostService::update($this->post, $validated);

            // attach tags
            $this->post->tags()->detach();
            PostService::attachTags($this->post, $this->selectedTags);

            if ($this->media) {
                // delete previous media
                $media = $this->post->media;

                $media = FileService::deleteFile($media);

                $media->delete();

                // add updated media
                $url = FileService::storeFile($this->media);

                MediaService::create(Post::class, $this->post, $url, 'image');
            }

            DB::commit();

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('post-event');

            AlertService::alert($this, config('messages.post.update'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            AlertService::alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        $validated = $this->validate([
            'media' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'topic_id' => 'required|integer',
            'heading' => 'required|string|max:255|unique:posts,heading,' . $this->post->id,
            'body' => 'required|string',
            'is_publish' => 'required|boolean'
        ]);

        return $validated;
    }

    public function render()
    {
        $topics = Topic::select('id', 'name')
            ->get();

        $tags = Tag::select('id', 'name')
            ->get();

        return view('livewire.post.edit', [
            'topics' => $topics,
            'tags' => $tags
        ]);
    }
}
