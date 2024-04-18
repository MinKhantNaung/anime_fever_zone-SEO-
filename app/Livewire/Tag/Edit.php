<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use App\Models\Media;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;

class Edit extends ModalComponent
{
    use WithFileUploads;

    public $media;
    public $name;
    public $body;

    public Tag $tag;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function updateTag()
    {
        // validate
        $this->validate([
            'media' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'name' => 'required|string|max:225|unique:tags,name,' . $this->tag->id,
            'body' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $this->tag->update([
                'name' => $this->name,
                'body' => $this->body
            ]);

            if ($this->media) {
                // delete previous media
                $media = $this->tag->media;

                $prev_url = $media->url;

                $path = parse_url($prev_url, PHP_URL_PATH); // Extracts the path part of the URL

                // Remove the '/storage' prefix from the path
                $pathWithoutStorage = str_replace('/storage', '', $path);

                Storage::delete('public/' . $pathWithoutStorage);

                $media->delete();

                // add updated media
                $file_name = uniqid() . '_' . $this->media->getClientOriginalName();

                $path = $this->media->storeAs('media', $file_name, 'public');

                $url = url(Storage::url($path));

                Media::create([
                    'mediable_id' => $this->tag->id,
                    'mediable_type' => Tag::class,
                    'url' => $url,
                    'mime' => 'image'
                ]);
            }

            DB::commit();

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('tag-reload');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function mount()
    {
        $this->name = $this->tag->name;
        $this->body = $this->tag->body;
    }

    public function render()
    {
        return view('livewire.tag.edit');
    }
}
