<?php

namespace App\Livewire\Section;

use App\Models\Post;
use App\Models\Section;
use App\Services\AlertService;
use App\Services\MediaService;
use App\Services\SectionService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $media = [];
    public $heading;
    public $body;

    public Post $post;

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
        $this->body = '';
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
            $this->dispatch('section-reload');
            return $this->redirectRoute('sections.index', $this->post->id, navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        return $this->validate([
            'media' => ['nullable', 'array'],
            'media.*' => ['file', 'mimes:webp,mp4', 'max:512000'],
            'heading' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);
    }

    public function render()
    {
        return view('livewire.section.create');
    }
}
