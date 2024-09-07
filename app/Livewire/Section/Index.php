<?php

namespace App\Livewire\Section;

use App\Models\Post;
use App\Models\Section;
use App\Services\AlertService;
use App\Services\SectionService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public Post $post;

    protected $alertService;
    protected $sectionService;

    public function boot(AlertService $alertService, SectionService $sectionService)
    {
        $this->alertService = $alertService;
        $this->sectionService = $sectionService;
    }

    public function removeSection(Section $section)
    {
        DB::beginTransaction();

        try {
            $this->sectionService->destroy($section);

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
