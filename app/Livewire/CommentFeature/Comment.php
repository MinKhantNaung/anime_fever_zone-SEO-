<?php

namespace App\Livewire\CommentFeature;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Comment extends Component
{
    use AuthorizesRequests;

    public $comment;

    public $users = [];

    public $isReplying = false;
    public $hasReplies = false;

    public $showOptions = false;

    public $isEditing = false;

    public $replyState = [
        'body' => ''
    ];

    public $editState = [
        'body' => ''
    ];

    protected $validationAttributes = [
        'replyState.body' => 'Reply',
        'editState.body' => 'Reply'
    ];

    public function updatedIsEditing($isEditing): void
    {
        if (!$isEditing) {
            return;
        }
        $this->editState = [
            'body' => $this->comment->body
        ];
    }

    public function editComment(): void
    {
        $this->authorize('update', $this->comment);
        $this->validate([
            'editState.body' => 'required|min:2'
        ]);
        $this->comment->update($this->editState);
        $this->isEditing = false;
        $this->showOptions = false;
    }

    #[On('refresh')]
    public function deleteComment(): void
    {
        $this->authorize('destroy', $this->comment);
        $this->comment->delete();
        $this->showOptions = false;
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function postReply(): void
    {
        if (!$this->comment->isParent()) {
            return;
        }
        $this->validate([
            'replyState.body' => 'required'
        ]);
        $reply = $this->comment->children()->make($this->replyState);
        $reply->user()->associate(Auth::user());
        $reply->commentable()->associate($this->comment->commentable);
        $reply->save();

        $this->replyState = [
            'body' => ''
        ];
        $this->isReplying = false;
        $this->showOptions = false;
        $this->dispatch('refresh')->self();
    }

    /**
     * @param $userName
     * @return void
     */
    public function selectUser($userName): void
    {
        if ($this->replyState['body']) {
            $this->replyState['body'] = preg_replace('/@(\w+)$/', '@'.str_replace(' ', '_', Str::lower($userName)).' ',
                $this->replyState['body']);

            $this->users = [];
        } elseif ($this->editState['body']) {
            $this->editState['body'] = preg_replace('/@(\w+)$/', '@'.str_replace(' ', '_', Str::lower($userName)).' ',
                $this->editState['body']);
            $this->users = [];
        }
    }

    #[On('getUsers')]
    public function getUsers($searchTerm): void
    {
        if (!empty($searchTerm)) {
            $this->users = User::where('name', 'like', '%'.$searchTerm.'%')->take(5)->get();
        } else {
            $this->users = [];
        }
    }

    public function render()
    {
        return view('livewire.comment-feature.comment');
    }
}
