<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use App\Services\AlertService;
use App\Services\MediaService;
use App\Services\TagService;
use App\Services\FileService;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    use WithFileUploads;

    public $media;
    public $name;
    public $body;

    public Tag $tag;

    protected $tagService;
    protected $mediaService;
    protected $alertService;
    protected $fileService;

    public function boot(TagService $tagService, MediaService $mediaService, AlertService $alertService, FileService $fileService)
    {
        $this->tagService = $tagService;
        $this->mediaService = $mediaService;
        $this->alertService = $alertService;
        $this->fileService = $fileService;
    }

    public function mount()
    {
        $this->name = $this->tag->name;
        $this->body = $this->tag->body;
    }

    public function updateTag()
    {
        // validate
        $validated = $this->validateRequests();

        DB::beginTransaction();
        try {
            $this->tagService->update($this->tag, $validated);

            if ($this->media) {
                // delete previous media
                $media = $this->tag->media;

                $this->mediaService->destroy($media);

                // add updated media
                $url = $this->fileService->storeFile($this->media);
                $this->mediaService->create(Tag::class, $this->tag, $url, 'image');
            }

            DB::commit();

            $this->alertService->alert($this, config('messages.tag.update'), 'success');

            return $this->redirectRoute('tags.index', navigate: true);
        } catch (\Throwable $e) {
            DB::rollback();
            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateRequests()
    {
        return $this->validate([
            'media' => ['nullable', 'file', 'mimes:webp', 'max:5120'],
            'name' => ['required', 'string', 'max:255', 'unique:tags,name,' . $this->tag->id],
            'body' => ['required', 'string'],
        ]);
    }

    public function render()
    {
        return view('livewire.tag.edit');
    }
}
