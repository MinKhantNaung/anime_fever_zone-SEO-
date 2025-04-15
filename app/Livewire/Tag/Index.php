<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use App\Services\AlertService;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Services\MediaService;
use App\Services\TagService;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    protected $tag;
    protected $alertService;
    protected $mediaService;
    protected $tagService;

    public function boot(
        Tag $tag,
        AlertService $alertService,
        MediaService $mediaService,
        TagService $tagService
    ) {
        $this->tag = $tag;
        $this->alertService = $alertService;
        $this->mediaService = $mediaService;
        $this->tagService = $tagService;
    }

    public function deleteTag(Tag $tag)
    {
        try {
            DB::transaction(function () use ($tag) {
                if ($tag->media) {
                    $this->mediaService->destroy($tag->media);
                }

                $this->tagService->destroy($tag);
            });

            $this->alertService->alert($this, config('messages.tag.destroy'), 'success');
            $this->dispatch('tag-reload');
        } catch (\Throwable $e) {
            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    #[On('tag-reload')]
    public function render()
    {
        $tags = $this->tag->getAllPerTwo();

        return view('livewire.tag.index', [
            'tags' => $tags
        ])
            ->title('Admin');
    }
}
