<?php

namespace App\Livewire\Topic;

use App\Models\Topic;
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

            return $this->redirect('/topics', navigate: true);
        } else {
            $this->validate([
                'name' => 'required|string|max:255|unique:topics,name'
            ]);

            Topic::create([
                'name' => $this->name
            ]);

            $this->reset();

            return $this->redirect('/topics', navigate: true);
        }
    }

    public function deleteTopic(Topic $topic)
    {
        $topic->delete();

        return $this->redirect('/topics', navigate: true);
    }

    public function render()
    {
        $topics = Topic::select('id', 'name', 'slug')
            ->get();

        return view('livewire.topic.create', [
            'topics' => $topics
        ]);
    }
}
