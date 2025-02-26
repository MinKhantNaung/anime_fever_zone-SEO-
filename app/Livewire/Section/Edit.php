<?php

namespace App\Livewire\Section;

use App\Models\Section;
use App\Services\AlertService;
use App\Services\MediaService;
use App\Services\SectionService;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    use WithFileUploads;

    public $media = [];
    public $heading;
    public $body;

    public Section $section;

    protected $alertService;
    protected $mediaService;
    protected $sectionService;

    public function boot(AlertService $alertService, MediaService $mediaService, SectionService $sectionService)
    {
        $this->alertService = $alertService;
        $this->mediaService = $mediaService;
        $this->sectionService = $sectionService;
    }

    public function mount()
    {
        $this->heading = $this->section->heading;
        $this->body = $this->section->body;
    }

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function updateSection()
    {
        $validated = $this->validateInputs();

        DB::beginTransaction();

        try {
            $this->sectionService->update($this->section, $validated);

            if (count($this->media) > 0) {
                $prevMedia = $this->section->media;

                $this->mediaService->destroyMultipleMedias($prevMedia);

                $this->mediaService->storeMultipleMedias(Section::class, $this->section, $this->media);
            }

            DB::commit();

            $this->alertService->alert($this, config('messages.section.update'), 'success');

            return $this->redirectRoute('sections.index', ['post' => $this->section->post_id], navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        $validated = $this->validate([
            'media' => ['nullable', 'array'],
            'media.*' => ['file', 'mimes:png,jpg,jpeg,webp,mp4', 'max:512000'],
            'heading' => ['nullable', 'string', 'max:225'],
            'body' => ['required', 'string'],
        ]);

        return $validated;
    }

    public function render()
    {
        return view('livewire.section.edit');
    }
}
