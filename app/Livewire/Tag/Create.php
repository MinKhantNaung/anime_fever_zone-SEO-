<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use App\Models\Media;
use App\Services\AlertService;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\TagService;
use Illuminate\Cache\TagSet;
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
        $validated = $this->validateInputs();

        DB::beginTransaction();

        try {
            $tag = TagService::create($validated);

            $url = FileService::storeFile($this->media);

            MediaService::create(Tag::class, $tag, $url, 'image');

            DB::commit();

            AlertService::alert($this, config('messages.tag.create'), 'success');

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('tag-reload');
        } catch (\Exception $e) {
            DB::rollback();
            AlertService::alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        $validated = $this->validate([
            'media' => 'required|file|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'name' => 'required|string|max:225|unique:tags,name',
            'body' => 'required|string'
        ]);

        return $validated;
    }

    public function render()
    {
        return view('livewire.tag.create');
    }
}
