<?php

namespace App\Livewire\Section;

use App\Models\Post;
use App\Models\Section;
use App\Services\AlertService;
use App\Services\FileService;
use App\Services\MediaService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public Post $post;

    public function removeSection(Section $section)
    {
        DB::beginTransaction();

        try {
            $medias = $section->media;

            MediaService::destroyMultipleMedias($medias);

            $section->delete();

            DB::commit();

            $this->dispatch('section-reload');

            AlertService::alert($this, config('messages.section.destroy'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            AlertService::alert($this, config('messages.common.error'), 'error');
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
