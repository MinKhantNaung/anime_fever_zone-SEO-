<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Post;
use Livewire\Component;

class Topic extends Component
{
    public $slug;

    public $popularPosts;

    public function mount()
    {
        $this->popularPosts = Post::with('media')
            ->select('id', 'heading', 'slug')
            ->whereHas('topic', function ($query) {
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
