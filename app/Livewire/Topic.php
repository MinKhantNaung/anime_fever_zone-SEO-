<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

final class Topic extends Component
{
    use WithPagination;

    public $slug;

    public $featuredPosts;

    protected $post;

    public function boot(Post $post)
    {
        $this->post = $post;
    }

    public function mount()
    {
        $this->featuredPosts = $this->post->getFeaturedPosts();
    }

    public function render()
    {
        $posts = $this->post->getPostsOfTopic($this->slug);

        return view('livewire.topic', [
            'posts' => $posts
        ])->title('Anime Fever Zone-' . ucfirst($this->slug));
    }
}
