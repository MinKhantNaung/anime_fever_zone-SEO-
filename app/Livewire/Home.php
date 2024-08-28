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

    protected $post;

    public function boot(Post $post)
    {
        $this->post = $post;
    }

    public function mount()
    {
        $this->featuredPosts = $this->post->getFeaturedPosts();
    }

    #[Title('Anime Fever Zone')]
    public function render()
    {
        $posts = $this->post->getPublishedPosts();

        return view('livewire.home', [
            'posts' => $posts
        ]);
    }
}
