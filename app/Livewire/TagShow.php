<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class TagShow extends Component
{
    use WithPagination;

    public $slug;
    public $tag;
    public $featuredPosts;

    public function mount()
    {
        $this->tag = Tag::query()
                        ->findWithSlug($this->slug)
                        ->first();

        $this->featuredPosts = Post::query()
                                    ->featuredPosts()
                                    ->get();
    }

    public function render()
    {
        $posts = Post::query()
                    ->getPostsOfTag($this->slug)
                    ->paginate(12);

        return view('livewire.tag-show', [
            'posts' => $posts
        ])->title(ucfirst($this->slug) . ' | Anime Fever Zone');
    }
}
