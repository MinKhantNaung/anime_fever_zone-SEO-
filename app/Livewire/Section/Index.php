<?php

namespace App\Livewire\Section;

use App\Models\Post;
use App\Models\Section;
use App\Services\AlertService;
use App\Services\MediaService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public Post $post;

    protected $alertService;
    protected $mediaService;

    public function boot(AlertService $alertService, MediaService $mediaService)
    {
        $this->alertService = $alertService;
        $this->mediaService = $mediaService;
    }

    public function removeSection(Section $section)
    {
        DB::beginTransaction();

        try {
            $medias = $section->media;

            $this->mediaService->destroyMultipleMedias($medias);

            $section->delete();

            DB::commit();

            $this->dispatch('section-reload');

            $this->alertService->alert($this, config('messages.section.destroy'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    #[On('section-reload')]
    public function mount()
    {
        $this->post->load('sections', 'media', 'topic', 'tags');
    }

    public function render()
    {
        return view('livewire.section.index')
            ->title('Admin');
    }
}
