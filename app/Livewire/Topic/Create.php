<?php

namespace App\Livewire\Topic;

use App\Models\Topic;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $topics;

    public function createNew()
    {
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        $topic = Topic::create([
            'name' => $this->name
        ]);

        $this->reset();

        // $this->topics = $this->topics->prepend($topic);
    }

    public function mount()
    {
        $this->topics = Topic::select('id', 'name', 'slug')
            ->get();
    }

    public function render()
    {
        return view('livewire.topic.create');
    }
}
