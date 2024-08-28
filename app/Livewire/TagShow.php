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

    protected $post;
    protected $tagModel;

    public function boot(Post $post, Tag $tagModel)
    {
        $this->post = $post;
        $this->tagModel = $tagModel;
    }

    public function mount()
    {
        $this->tag = $this->tagModel->findWithSlug($this->slug);

        $this->featuredPosts = $this->post->getFeaturedPosts();
    }

    public function render()
    {
        $posts = $this->post->getPostsOfTag($this->slug);

        return view('livewire.tag-show', [
            'posts' => $posts
        ])->title(ucfirst($this->slug) . ' | Anime Fever Zone');
    }
}
