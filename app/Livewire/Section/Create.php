<?php

namespace App\Livewire\Section;

use App\Models\Post;
use App\Models\Section;
use App\Services\AlertService;
use App\Services\MediaService;
use App\Services\SectionService;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $media = [];
    public $heading;
    public $body;

    public Post $post;

    protected $alertService;
    protected $mediaService;
    protected $sectionService;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function boot(AlertService $alertService, MediaService $mediaService, SectionService $sectionService)
    {
        $this->alertService = $alertService;
        $this->mediaService = $mediaService;
        $this->sectionService = $sectionService;
    }

    public function addSection()
    {
        $validated = $this->validateInputs();

        DB::beginTransaction();

        try {
            $section = $this->sectionService->create($this->post, $validated);

            $this->mediaService->storeMultipleMedias(Section::class, $section, $this->media);

            DB::commit();

            $this->alertService->alert($this, config('messages.section.create'), 'success');

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('section-reload');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        $validated = $this->validate([
            'media.*' => 'file|mimes:png,jpg,jpeg,svg,webp,mp4|max:512000',
            'heading' => 'nullable|string|max:225',
            'body' => 'required|string'
        ]);

        return $validated;
    }

    public function render()
    {
        return view('livewire.section.create');
    }
}
