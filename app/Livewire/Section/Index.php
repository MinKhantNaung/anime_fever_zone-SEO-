<?php

namespace App\Livewire\Section;

use App\Models\Post;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
                $url = $media->url;

                $path = parse_url($url, PHP_URL_PATH); // Extracts the path part of the URL

                // Remove the '/storage' prefix from the path
                $pathWithoutStorage = str_replace('/storage', '', $path);

                $media->delete();

                Storage::delete('public/' . $pathWithoutStorage);
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
        $this->post->load('sections');
    }

    public function render()
    {
        return view('livewire.section.index');
    }
}
