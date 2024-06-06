<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class Topic extends Component
{
    public $slug;

    public $popularPosts;

    public function mount()
    {
        $this->popularPosts = Post::select('id', 'heading', 'slug')
            ->orderByDesc('view')
            ->whereHas('topic', function ($query) {
                $query->where('slug', $this->slug);
            })
            ->where('is_publish', true)
            ->take(3)
            ->get();
    }

    public function render()
    {
        $posts = Post::with('media', 'topic', 'tags')
            ->select('id', 'topic_id', 'heading', 'slug', 'body', 'created_at')
            ->orderByDesc('id')
            ->whereHas('topic', function ($query) {
                $query->where('slug', $this->slug);
            })
            ->where('is_publish', true)
            ->paginate(20);

        return view('livewire.topic', [
            'posts' => $posts
        ])->title('Anime Fever Zone-' . ucfirst($this->slug));
    }
}
