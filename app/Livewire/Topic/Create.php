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

    protected $topicModel;
    protected $alertService;
    protected $topicService;

    public function boot(Topic $topicModel, AlertService $alertService, TopicService $topicService)
    {
        $this->topicModel = $topicModel;
        $this->alertService = $alertService;
        $this->topicService = $topicService;
    }

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
        $this->topicService->destroy($topic);

        $this->dispatch('topic-created');

        $this->alertService->alert($this, config('messages.topic.destroy'), 'success');
    }

    protected function updateTopic()
    {
        $validated = $this->validateForUpdate();

        $this->topicService->update($this->topic, $validated);

        $this->reset();

        $this->dispatch('topic-created');

        $this->alertService->alert($this, config('messages.topic.update'), 'success');
    }

    protected function storeTopic()
    {
        $validated = $this->validateForStore();

        $this->topicService->create($validated);

        $this->reset();

        $this->dispatch('topic-created');

        $this->alertService->alert($this, config('messages.topic.create'), 'success');
    }

    protected function validateForUpdate()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:topics,name,' . $this->topic->id],
        ]);

        return $validated;
    }

    protected function validateForStore()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:topics,name'],
        ]);

        return $validated;
    }

    #[On('topic-created')]
    public function render()
    {
        $topics = $this->topicModel->getAllByName();

        return view('livewire.topic.create', [
            'topics' => $topics
        ])
        ->title('Admin');
    }
}
