<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use App\Services\AlertService;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\TagService;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $media;
    public $name;
    public $body;

    protected $alertService;
    protected $fileService;
    protected $mediaService;
    protected $tagService;

    public function boot(AlertService $alertService, FileService $fileService, MediaService $mediaService, TagService $tagService)
    {
        $this->alertService = $alertService;
        $this->fileService = $fileService;
        $this->mediaService = $mediaService;
        $this->tagService = $tagService;
    }

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function createTag()
    {
        $validated = $this->validateInputs();

        DB::beginTransaction();

        try {
            $tag = $this->tagService->create($validated);

            $url = $this->fileService->storeFile($this->media);

            $this->mediaService->create(Tag::class, $tag, $url, 'image');

            DB::commit();

            $this->alertService->alert($this, config('messages.tag.create'), 'success');

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('tag-reload');
        } catch (\Exception $e) {
            DB::rollback();
            $this->alertService->alert($this, config('messages.common.error'), 'error');
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
