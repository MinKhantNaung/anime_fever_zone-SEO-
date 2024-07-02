<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Post;
use Livewire\Component;

class Topic extends Component
{
    public $slug;

    public $featuredPosts;

    public function mount()
    {
        $this->featuredPosts = Post::with('media')
            ->select('id', 'heading', 'slug')
            ->whereHas('topic', function ($query) {
                $query->where('slug', $this->slug);
            })
            ->where('is_publish', true)
            ->where('is_feature', true)
            ->take(5)
            ->get();
    }

    public function render()
    {
        $posts = Post::with('media', 'topic', 'tags')
            ->select('id', 'topic_id', 'heading', 'slug', 'body', 'updated_at')
            ->orderBy('updated_at', 'desc')
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
