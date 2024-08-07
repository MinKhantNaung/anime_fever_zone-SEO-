<?php

namespace App\Livewire\Topic;

use App\Models\Topic;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    public $name;

    public ?Topic $topic;
    public $editMode = false;

    public function updateEditMode(Topic $topic)
    {
        $this->topic = $topic;
        $this->name = $topic->name;
        $this->editMode = true;
    }

    public function createNew()
    {
        if ($this->editMode) {
            $this->validate([
                'name' => 'required|string|max:255|unique:topics,name,' . $this->topic->id
            ]);

            $this->topic->update([
                'name' => $this->name
            ]);

            $this->reset();

            $this->dispatch('topic-created');

            $this->dispatch('swal', [
                'title' => 'Topic updated successfully !',
                'icon' => 'success',
                'iconColor' => 'green'
            ]);
        } else {
            $this->validate([
                'name' => 'required|string|max:255|unique:topics,name'
            ]);

            Topic::create([
                'name' => $this->name
            ]);

            $this->reset();

            $this->dispatch('topic-created');

            $this->dispatch('swal', [
                'title' => 'Topic created successfully !',
                'icon' => 'success',
                'iconColor' => 'green'
            ]);
        }
    }

    public function deleteTopic(Topic $topic)
    {
        $topic->delete();

        $this->dispatch('topic-created');

        $this->dispatch('swal', [
            'title' => 'Topic deleted successfully !',
            'icon' => 'success',
            'iconColor' => 'green'
        ]);
    }

    #[On('topic-created')]
    public function render()
    {
        $topics = Topic::select('id', 'name', 'slug')
            ->get();

        return view('livewire.topic.create', [
            'topics' => $topics
        ])
        ->title('Admin');
    }
}
