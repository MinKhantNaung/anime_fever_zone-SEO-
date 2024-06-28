<?php

namespace App\Livewire\Section;

use App\Models\Media;
use App\Models\Post;
use App\Models\Section;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $media = [];
    public $heading;
    public $body;

    public Post $post;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function addSection()
    {
        $this->validate([
            'media.*' => 'file|mimes:png,jpg,jpeg,svg,webp,mp4|max:512000',
            'heading' => 'nullable|string|max:225',
            'body' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $section = Section::create([
                'post_id' => $this->post->id,
                'heading' => $this->heading,
                'body' => $this->body
            ]);

            foreach ($this->media as $media) {
                // get mime type
                $mime = $this->getMime($media);

                $url = FileService::storeFile($media);

                // create media
                Media::create([
                    'mediable_id' => $section->id,
                    'mediable_type' => Section::class,
                    'url' => $url,
                    'mime' => $mime
                ]);
            }

            DB::commit();

            // success toast
            $this->dispatch('swal', [
                'title' => 'Section added successfully !',
                'icon' => 'success',
                'iconColor' => 'green'
            ]);

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('section-reload');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('swal', [
                'title' => 'An unexpected error occurred. Please try again later.',
                'icon' => 'error',
                'iconColor' => 'red'
            ]);
        }
    }

    public function getMime($media): string
    {
        if (str()->contains($media->getMimeType(), 'video')) {
            return 'video';
        } else {
            return 'image';
        }
    }

    public function render()
    {
        return view('livewire.section.create');
    }
}
