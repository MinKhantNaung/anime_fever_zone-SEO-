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
        $this->post = Post::with('media', 'topic', 'tags', 'sections', 'comments')
            ->select('id', 'topic_id', 'heading', 'body', 'view', 'created_at')
            ->where('slug', $this->slug)
            ->first();

        $this->popularPosts = Post::select('id', 'heading', 'slug')
            ->inRandomOrder()
            ->where('id', '!=', $this->post->id)
            ->take(3)
            ->get();

        if ($this->post) {
            // Increment view count
            $this->post->view++;
            $this->post->save();
        }
    }

    public function render()
    {
        return view('livewire.post-show');
    }
}
