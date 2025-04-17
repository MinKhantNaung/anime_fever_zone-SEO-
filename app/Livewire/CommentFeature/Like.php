<?php

namespace App\Livewire\CommentFeature;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

final class Like extends Component
{
    public $comment;
    public $count;

    public function mount(Comment $comment): void
    {
        $this->comment = $comment;
        $this->count = $comment->likes_count;
    }

    public function like(): void
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();
        if ($this->comment->isLiked()) {
            $this->comment->removeLike();

            $this->count--;
        } elseif (Auth::user()) {
            $this->comment->likes()->create([
                'user_id' => Auth::id(),
            ]);

            $this->count++;
        } elseif ($ip && $userAgent) {
            $this->comment->likes()->create([
                'ip' => $ip,
                'user_agent' => $userAgent,
            ]);

            $this->count++;
        }
    }

    public function render()
    {
        return view('livewire.comment-feature.like');
    }
}
