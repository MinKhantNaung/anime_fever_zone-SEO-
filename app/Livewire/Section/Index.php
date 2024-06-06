<?php

namespace App\Livewire\Section;

use App\Models\Post;
use App\Models\Section;
use App\Services\FileService;
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

            foreach ($medias as $media) {
                $media = (new FileService)->deleteFile($media);

                $media->delete();
            }

            $section->delete();

            DB::commit();

            $this->dispatch('section-reload');

            $this->dispatch('swal', [
                'title' => 'Section removed successfully !',
                'icon' => 'success',
                'iconColor' => 'green'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('swal', [
                'title' => 'An unexpected error occurred. Please try again later.',
                'icon' => 'error',
                'iconColor' => 'red'
            ]);
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
