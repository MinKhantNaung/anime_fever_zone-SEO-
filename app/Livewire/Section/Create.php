<?php

namespace App\Livewire\Section;

use App\Models\Media;
use App\Models\Post;
use App\Models\Section;
use App\Services\AlertService;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\SectionService;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $media = [];
    public $heading;
    public $body;

    public Post $post;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function addSection()
    {
        $validated = $this->validateInputs();

        DB::beginTransaction();

        try {
            $section = SectionService::create($this->post, $validated);

            MediaService::storeMultipleMedias(Section::class, $section, $this->media);

            DB::commit();

            AlertService::alert($this, config('messages.section.create'), 'success');

            $this->reset();
            $this->dispatch('close');
            $this->dispatch('section-reload');
        } catch (\Exception $e) {
            DB::rollBack();

            AlertService::alert($this, config('messages.common.error'), 'error');
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
