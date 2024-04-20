<?php

namespace App\Livewire\Section;

use App\Models\Post;
use Livewire\Component;

class Index extends Component
{
    public Post $post;

    public function mount()
    {
        $this->post->load('sections');
    }

    public function render()
    {
        return view('livewire.section.index');
    }
}
