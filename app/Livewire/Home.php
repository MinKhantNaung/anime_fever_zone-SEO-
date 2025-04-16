<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Post;
use Livewire\Attributes\Computed;
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
        $this->featuredPosts = $this->post->getFeaturedPosts();
    }

    #[Computed()]
    public function posts()
    {
        return $this->post->getPublishedPosts();
    }

    #[Title('Anime Fever Zone')]
    public function render()
    {
        return view('livewire.home');
    }
}
