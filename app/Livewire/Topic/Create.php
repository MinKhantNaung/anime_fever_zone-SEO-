<?php

namespace App\Livewire\Topic;

use App\Models\Topic;
use App\Services\AlertService;
use App\Services\TopicService;
use Livewire\Attributes\On;
use Livewire\Component;

final class Create extends Component
{
    public $name;

    public ?Topic $topic;
    public $editMode = false;

    protected $topicModel;
    protected $alertService;
    protected $topicService;

    public function boot(
        Topic $topicModel,
        AlertService $alertService,
        TopicService $topicService
    ) {
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

    public function createOrUpdateTopic()
    {
        $this->editMode ? $this->updateTopic() : $this->storeTopic();
    }

    public function deleteTopic(Topic $topic)
    {
        $this->topicService->destroy($topic);

        $this->topic = null;
        $this->name = null;
        $this->editMode = false;
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

    protected function validateForUpdate(): array
    {
        return $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:topics,name,' . $this->topic->id],
        ]);
    }

    protected function validateForStore(): array
    {
        return $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:topics,name'],
        ]);
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
