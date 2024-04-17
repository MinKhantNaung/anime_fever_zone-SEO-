<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use App\Models\Media;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $media;
    public $name;

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
        ]);

        DB::beginTransaction();

        try {
            $tag = Tag::create([
                'name' => $this->name,
            ]);

            // add media
            $file_name = uniqid() . '_' . $this->media->getClientOriginalName();

            $path = $this->media->storeAs('media', $file_name, 'public');

            $url = url(Storage::url($path));

            // create media
            Media::create([
                'mediable_id' => $tag->id,
                'mediable_type' => Tag::class,
                'url' => $url,
                'mime' => 'image'
            ]);

            DB::commit();

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('tag-reload');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.tag.create');
    }
}
