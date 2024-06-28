<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use App\Models\Media;
use App\Services\FileService;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $media;
    public $name;
    public $body;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function createTag()
    {
        // validate
        $this->validate([
            'media' => 'required|file|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'name' => 'required|string|max:225|unique:tags,name',
            'body' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $tag = Tag::create([
                'name' => $this->name,
                'body' => $this->body
            ]);

            // add media
            $url = FileService::storeFile($this->media);

            // create media
            Media::create([
                'mediable_id' => $tag->id,
                'mediable_type' => Tag::class,
                'url' => $url,
                'mime' => 'image'
            ]);

            DB::commit();

            // success toast
            $this->dispatch('swal', [
                'title' => 'Tag created successfully !',
                'icon' => 'success',
                'iconColor' => 'green'
            ]);

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('tag-reload');
        } catch (\Exception $e) {
            DB::rollback();

            $this->dispatch('swal', [
                'title' => 'An unexpected error occurred. Please try again later.',
                'icon' => 'error',
                'iconColor' => 'red'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tag.create');
    }
}
