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

class Edit extends ModalComponent
{
    use WithFileUploads;

    public $media;
    public $name;
    public $body;

    public Tag $tag;

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

    public function mount()
    {
        $this->name = $this->tag->name;
        $this->body = $this->tag->body;
    }

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function updateTag()
    {
        $validated = $this->validateInputs();

        DB::beginTransaction();

        try {
            $this->tagService->update($this->tag, $validated);

            if ($this->media) {
                // delete previous media
                $media = $this->tag->media;

                if ($media) {
                    $this->mediaService->destroy($media);
                }

                // add updated media
                $url = $this->fileService->storeFile($this->media);

                $this->mediaService->create(Tag::class, $this->tag, $url, 'image');
            }

            DB::commit();

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('tag-reload');

            $this->alertService->alert($this, config('messages.tag.update'), 'success');
        } catch (\Exception $e) {
            DB::rollback();
            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        $validated = $this->validate([
            'media' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:5120'],
            'name' => ['required', 'string', 'max:225', 'unique:tags,name,' . $this->tag->id],
            'body' => ['required', 'string'],
        ]);

        return $validated;
    }

    public function render()
    {
        return view('livewire.tag.edit');
    }
}
