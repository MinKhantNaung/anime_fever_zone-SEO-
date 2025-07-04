<?php

namespace App\Livewire\CommentFeature;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Comments extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $model;

    public $users = [];

    public $showDropdown = false;

    protected $numberOfPaginatorsRendered = [];

    public $newCommentState = [
        'body' => ''
    ];

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    protected $validationAttributes = [
        'newCommentState.body' => 'comment'
    ];

    #[On('refreshComments')]
    public function render()
    {
        $comments = $this->model
            ->comments()
            ->with('user', 'children.user', 'children.children')
            ->parent()
            ->latest()
            ->paginate(config('commentify.pagination_count', 10));

        if ($comments->isEmpty() && $comments->currentPage() > 1) {
            $this->setPage($comments->lastPage());
            return $this->render();
        }

        return view('livewire.comment-feature.comments', [
            'comments' => $comments
        ]);
    }

    #[On('refresh')]
    public function postComment(): void
    {
        $this->validate([
            'newCommentState.body' => ['required']
        ]);

        $comment = $this->model->comments()->make($this->newCommentState);
        $comment->user()->associate(Auth::user());
        $comment->save();

        $this->newCommentState = [
            'body' => ''
        ];
        $this->users = [];
        $this->showDropdown = false;

        $this->resetPage();
        session()->flash('message', 'Comment Posted Successfully!');
    }
}
