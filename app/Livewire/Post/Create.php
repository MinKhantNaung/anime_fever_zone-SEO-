<?php

namespace App\Livewire\Post;

use App\Models\Post;
use App\Models\Media;
use App\Models\Tag;
use App\Models\Topic;
use App\Services\FileService;
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
        $this->validate([
            'media' => 'required|file|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'topic_id' => 'required|integer',
            'heading' => 'required|string|max:255|unique:posts,heading',
            'body' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            $post = Post::create([
                'topic_id' => $this->topic_id,
                'heading' => $this->heading,
                'body' => $this->body,
                'is_publish' => $this->is_publish
            ]);

            // attach tags
            if ($this->selectedTags != null) {
                $post->tags()->attach($this->selectedTags);
            }

            // add media
            $url = FileService::storeFile($this->media);

            // create media
            Media::create([
                'mediable_id' => $post->id,
                'mediable_type' => Post::class,
                'url' => $url,
                'mime' => 'image'
            ]);

            DB::commit();

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('post-event');

            $this->dispatch('swal', [
                'title' => 'Post created successfully !',
                'icon' => 'success',
                'iconColor' => 'green'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('swal', [
                'title' => 'An unexpected error occurred. Please try again later.',
                'icon' => 'error',
                'iconColor' => 'red'
            ]);
        }
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
