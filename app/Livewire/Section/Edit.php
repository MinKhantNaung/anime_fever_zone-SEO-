<?php

namespace App\Livewire\Section;

use App\Models\Media;
use App\Models\Section;
use App\Services\AlertService;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\SectionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    use WithFileUploads;

    public $media = [];
    public $heading;
    public $body;

    public Section $section;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function updateSection()
    {
        $validated = $this->validateInputs();

        DB::beginTransaction();

        try {
            SectionService::update($this->section, $validated);

            if (count($this->media) > 0) {
                $prevMedia = $this->section->media;

                MediaService::destroyMultipleMedias($prevMedia);

                MediaService::storeMultipleMedias(Section::class, $this->section, $this->media);
            }

            DB::commit();

            AlertService::alert($this, config('messages.section.update'), 'success');

            return $this->redirectRoute('sections.index', ['post' => $this->section->post_id], navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            AlertService::alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateInputs()
    {
        $validated = $this->validate([
            'media.*' => 'file|mimes:png,jpg,jpeg,svg,webp,mp4|max:512000',
            'heading' => 'nullable|string|max:255',
            'body' => 'required|string'
        ]);

        return $validated;
    }

    public function mount()
    {
        $this->heading = $this->section->heading;
        $this->body = $this->section->body;
    }

    public function render()
    {
        return view('livewire.section.edit');
    }
}
