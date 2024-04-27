<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostShow extends Component
{
    public $slug;
    public $post;
    public $popularPosts;

    public function mount()
    {
        $this->popularPosts = Post::select('id', 'heading', 'slug')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $this->post = Post::with('media', 'topic', 'tags', 'sections', 'comments')
            ->select('id', 'topic_id', 'heading', 'body', 'created_at')
            ->where('slug', $this->slug)
            ->first();
    }

    public function render()
    {
        return view('livewire.post-show');
    }
}
