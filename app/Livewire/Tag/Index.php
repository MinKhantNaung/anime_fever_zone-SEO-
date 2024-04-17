<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
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

            $url = $media->url;

            $path = parse_url($url, PHP_URL_PATH); // Extracts the path part of the URL

            // Remove the '/storage' prefix from the path
            $pathWithoutStorage = str_replace('/storage', '', $path);

            $media->delete();

            $tag->delete();

            DB::commit();

            // Delete the file after the transaction is successfully committed
            Storage::delete('public/' . $pathWithoutStorage);

            $this->dispatch('tag-reload');
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    #[On('tag-reload')]
    public function render()
    {
        $tags = Tag::with('media')
            ->select('id', 'name', 'slug')
            ->orderBy('id', 'desc')
            ->paginate(2);

        return view('livewire.tag.index', [
            'tags' => $tags
        ]);
    }
}
