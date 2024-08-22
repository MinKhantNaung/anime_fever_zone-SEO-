<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use App\Models\Media;
use App\Services\AlertService;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\TagService;
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
        $validated = $this->validateInputs();

        DB::beginTransaction();

        try {
            TagService::update($this->tag, $validated);

            if ($this->media) {
                // delete previous media
                $media = $this->tag->media;
                MediaService::destroy($media);

                // add updated media
                $url = FileService::storeFile($this->media);

                MediaService::create(Tag::class, $this->tag, $url, 'image');
            }

            DB::commit();

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('tag-reload');

            AlertService::alert($this, config('messages.tag.update'), 'success');
        } catch (\Exception $e) {
            DB::rollback();
            AlertService::alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        $validated = $this->validate([
            'media' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'name' => 'required|string|max:225|unique:tags,name,' . $this->tag->id,
            'body' => 'required|string'
        ]);

        return $validated;
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
