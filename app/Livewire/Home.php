<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public $popularPosts;

    public function mount()
    {
        $this->popularPosts = Post::select('id', 'heading', 'slug')
            ->orderByDesc('view')
            ->where('is_publish', true)
            ->take(3)
            ->get();
    }

    public function render()
    {
        $posts = Post::with('media', 'topic', 'tags')
            ->select('id', 'topic_id', 'heading', 'slug', 'body', 'created_at')
            ->orderByDesc('id')
            ->where('is_publish', true)
            ->paginate(20);

        return view('livewire.home', [
            'posts' => $posts
        ]);
    }
}
