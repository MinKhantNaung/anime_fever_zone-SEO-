<?php

namespace App\Livewire\Topic;

use App\Models\Topic;
use App\Services\AlertService;
use App\Services\TopicService;
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
            $this->updateTopic();
        } else {
            $this->storeTopic();
        }
    }

    public function deleteTopic(Topic $topic)
    {
        $topic->delete();

        $this->dispatch('topic-created');

        AlertService::alert($this, config('messages.topic.destroy'), 'success');
    }

    protected function updateTopic()
    {
        $validated = $this->validateForUpdate();

        TopicService::update($this->topic, $validated);

        $this->reset();

        $this->dispatch('topic-created');

        AlertService::alert($this, config('messages.topic.update'), 'success');
    }

    protected function storeTopic()
    {
        $validated = $this->validateForStore();

        TopicService::create($validated);

        $this->reset();

        $this->dispatch('topic-created');

        AlertService::alert($this, config('messages.topic.create'), 'success');
    }

    protected function validateForUpdate()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:topics,name,' . $this->topic->id
        ]);

        return $validated;
    }

    protected function validateForStore()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:topics,name'
        ]);

        return $validated;
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
