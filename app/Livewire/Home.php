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

    public $featuredPosts;

    public function mount()
    {
        $this->featuredPosts = Post::with('media')
            ->select('id', 'heading', 'slug')
            ->where('is_publish', true)
            ->where('is_feature', true)
            ->take(5)
            ->get();
    }

    #[Title('Anime Fever Zone')]
    public function render()
    {
        $posts = Post::with('media', 'topic', 'tags')
            ->select('id', 'topic_id', 'heading', 'slug', 'body', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->where('is_publish', true)
            ->paginate(20);

        return view('livewire.home', [
            'posts' => $posts
        ]);
    }
}
