<?php

namespace App\Livewire\Components;

use App\Models\Topic;
use Livewire\Attributes\On;
use Livewire\Component;

class TopicNav extends Component
{
    public $topics;

    protected $topic;

    public function boot(Topic $topic)
    {
        $this->topic = $topic;
    }

    #[On('topic-created')]
    public function mount()
    {
        $this->topics = $this->topic->getAllByName();
    }

    public function render()
    {
        return view('livewire.components.topic-nav');
    }
}
