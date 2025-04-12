<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use App\Models\SiteSetting;
use App\Services\AlertService;
use Illuminate\Validation\Rule;
use App\Services\SubscriberService;
use function Illuminate\Support\defer;

class PostShow extends Component
{
    public $slug;
    public $post;
    public $featuredPosts;

    public $email;
    public bool $emailVerifyStatus;

    protected $postModel;
    protected $siteSetting;
    protected $alertService;
    protected $subscriberService;

    public function boot(Post $postModel, SiteSetting $siteSetting, AlertService $alertService, SubscriberService $subscriberService)
    {
        $this->postModel = $postModel;
        $this->siteSetting = $siteSetting;
        $this->alertService = $alertService;
        $this->subscriberService = $subscriberService;
    }

    public function mount()
    {
        $this->post = $this->postModel->findPostWithSlug($this->slug);

        $this->featuredPosts = $this->postModel->featuredPostsForPostPage($this->post->id);

        $this->emailVerifyStatus = $this->siteSetting->first()->email_verify_status;
    }

    public function subscribe()
    {
        $validated = $this->validateForSubscribe();

        $token = hash('sha256', time());

        $this->subscriberService->store($validated, $token);

        defer(fn () => $this->subscriberService->sendMail($validated, $token))->always();

        $this->email = '';
        $this->alertService->alertForSubscribe($this, config('messages.email.subscriber_check'), 'success');
    }

    protected function validateForSubscribe()
    {
        $validated = $this->validate([
            'email' => ['required', 'string', 'email', Rule::unique('subscribers')->where(function ($query) {
                return $query->where('status', 'Active');
            })]
        ]);

        return $validated;
    }

    public function render()
    {
        return view('livewire.post-show')
            ->title(ucwords(str_replace('-', ' ', $this->slug)) . ' - Anime Fever Zone');
    }
}
