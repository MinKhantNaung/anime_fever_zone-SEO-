<?php

namespace App\Livewire\Components;

use App\Models\Topic;
use Livewire\Attributes\On;
use Livewire\Component;

class TopicNav extends Component
{
    public $topics;

    #[On('topic-created')]
    public function mount()
    {
        $this->topics = Topic::select('id', 'name', 'slug')
            ->get();
    }

    public function render()
    {
        return view('livewire.components.topic-nav');
    }
}
