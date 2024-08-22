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
        $this->featuredPosts = Post::query()
                                    ->featuredPosts()
                                    ->get();
    }

    #[Title('Anime Fever Zone')]
    public function render()
    {
        $posts = Post::query()
                    ->getPublishedPosts()
                    ->paginate(12);

        return view('livewire.home', [
            'posts' => $posts
        ]);
    }
}
