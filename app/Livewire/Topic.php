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
        $this->featuredPosts = Post::query()
                                    ->featuredPosts()
                                    ->get();
    }

    public function render()
    {
        $posts = Post::query()
                    ->getPostsOfTopic($this->slug)
                    ->paginate(12);

        return view('livewire.topic', [
            'posts' => $posts
        ])->title('Anime Fever Zone-' . ucfirst($this->slug));
    }
}
