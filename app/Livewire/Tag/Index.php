<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use App\Services\AlertService;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Services\FileService;
use App\Services\MediaService;
use App\Services\TagService;
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

            MediaService::destroy($media);

            TagService::destroy($tag);

            DB::commit();

            AlertService::alert($this, config('messages.tag.destroy'), 'success');

            $this->dispatch('tag-reload');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            AlertService::alert($this, config('messages.common.error'), 'error');
        }
    }

    #[On('tag-reload')]
    public function render()
    {
        $tags = Tag::query()
                    ->getAll()
                    ->paginate(2);

        return view('livewire.tag.index', [
            'tags' => $tags
        ])
        ->title('Admin');
    }
}
