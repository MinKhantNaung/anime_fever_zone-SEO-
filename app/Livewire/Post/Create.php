<?php

namespace App\Livewire\Post;

use App\Models\Post;
use App\Models\Media;
use App\Models\Tag;
use App\Models\Topic;
use App\Services\AlertService;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\PostService;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $media;
    public $topic_id;
    public $heading;
    public $body;
    public $is_publish = false;
    public $selectedTags = null;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function createPost()
    {
        $validated = $this->validateInputs();

        DB::beginTransaction();
        try {
            $post = PostService::create($validated);

            // attach tags
            PostService::attachTags($post, $this->selectedTags);

            // add media
            $url = FileService::storeFile($this->media);

            // create media
            MediaService::create(Post::class, $post, $url, 'image');

            DB::commit();

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('post-event');

            AlertService::alert($this, config('messages.post.create'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            AlertService::alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        $validated = $this->validate([
            'media' => 'required|file|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'topic_id' => 'required|integer',
            'heading' => 'required|string|max:255|unique:posts,heading',
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

        return view('livewire.post.create', [
            'topics' => $topics,
            'tags' => $tags
        ]);
    }
}
