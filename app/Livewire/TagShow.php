<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class TagShow extends Component
{
    use WithPagination;

    public $slug;
    public $tag;
    public $popularPosts;

    public function mount()
    {
        $this->tag = Tag::with('media')
            ->select('id', 'name', 'body')
            ->where('slug', $this->slug)
            ->first();

        $this->popularPosts = Post::with('media')
            ->select('id', 'heading', 'slug')
            ->whereHas('tags', function ($query) {
                $query->where('slug', $this->slug);
            })
            ->where('is_publish', true)
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->take(3)
            ->get();
    }

    public function render()
    {
        $posts = Post::with('media', 'topic', 'tags')
            ->select('id', 'topic_id', 'heading', 'slug', 'body', 'created_at')
            ->orderByDesc('id')
            ->whereHas('tags', function ($query) {
                $query->where('slug', $this->slug);
            })
            ->where('is_publish', true)
            ->paginate(15);

        return view('livewire.tag-show', [
            'posts' => $posts
        ])->title(ucfirst($this->slug) . ' | Anime Fever Zone');
    }
}
