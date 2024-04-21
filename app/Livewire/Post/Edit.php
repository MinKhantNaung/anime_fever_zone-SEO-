<?php

namespace App\Livewire\Post;

use App\Models\Media;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Topic;
use App\Services\FileService;
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

    public function updatePost()
    {
        // dd($this->selectedTags);
        // validate
        $this->validate([
            'media' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'topic_id' => 'required|integer',
            'heading' => 'required|string|max:255|unique:posts,heading,' . $this->post->id,
            'body' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $this->post->update([
                'topic_id' => $this->topic_id,
                'heading' => $this->heading,
                'body' => $this->body,
                'is_publish' => $this->is_publish
            ]);

            // attach tags
            $this->post->tags()->detach();

            if ($this->selectedTags != null) {
                $this->post->tags()->attach($this->selectedTags);
            }

            if ($this->media) {
                // delete previous media
                $media = $this->post->media;

                $media = (new FileService)->deleteFile($media);

                $media->delete();

                // add updated media
                $url = (new FileService)->storeFile($this->media);

                Media::create([
                    'mediable_id' => $this->post->id,
                    'mediable_type' => Post::class,
                    'url' => $url,
                    'mime' => 'image'
                ]);
            }

            DB::commit();

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('post-event');

            $this->dispatch('swal', [
                'title' => 'Post updated successfully !',
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

    public function mount()
    {
        $this->topic_id = $this->post->topic_id;
        $this->heading = $this->post->heading;
        $this->body = $this->post->body;
        $this->is_publish = $this->post->is_publish;
        $this->selectedTags = $this->post->tags()->pluck('tags.id')->toArray();
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
