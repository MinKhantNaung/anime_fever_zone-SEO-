<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public function deleteTag(Tag $tag)
    {
        DB::beginTransaction();

        try {
            $media = $tag->media;

            $media = FileService::deleteFile($media);

            $media->delete();

            // Remove relationships between tag and associated post
            $tag->posts()->detach();

            $tag->delete();

            DB::commit();

            $this->dispatch('swal', [
                'title' => 'Tag deleted successfully !',
                'icon' => 'success',
                'iconColor' => 'green'
            ]);

            $this->dispatch('tag-reload');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('swal', [
                'title' => 'An unexpected error occurred. Please try again later.',
                'icon' => 'error',
                'iconColor' => 'red'
            ]);
        }
    }

    #[On('tag-reload')]
    public function render()
    {
        $tags = Tag::with('media')
            ->select('id', 'name', 'slug', 'body')
            ->orderBy('id', 'desc')
            ->paginate(2);

        return view('livewire.tag.index', [
            'tags' => $tags
        ])
        ->title('Admin');
    }
}
