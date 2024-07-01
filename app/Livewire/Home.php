<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Home extends Component
{
    use WithPagination;

    public $popularPosts;

    public function mount()
    {
        $this->popularPosts = Post::with('media')
            ->select('id', 'heading', 'slug')
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->where('is_publish', true)
            ->take(3)
            ->get();
    }

    #[Title('Anime Fever Zone')]
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
