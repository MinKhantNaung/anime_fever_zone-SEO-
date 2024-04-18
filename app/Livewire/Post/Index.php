<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[On('post-event')]
    public function render()
    {
        $posts = Post::with('media', 'topic', 'tags', 'sections', 'comments')
            ->select('id', 'topic_id', 'heading', 'slug', 'body', 'is_publish', 'created_at')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.post.index', [
            'posts' => $posts
        ]);
    }
}
