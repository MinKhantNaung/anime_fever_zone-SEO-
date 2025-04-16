<?php

namespace App\Livewire\Post;

use App\Models\Post;
use App\Mail\PostMail;
use Livewire\Component;
use App\Models\Subscriber;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Services\AlertService;
use App\Services\PostService;
use App\Services\SubscriberService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function Illuminate\Support\defer;

class Index extends Component
{
    use WithPagination;

    protected $post;
    protected $alertService;
    protected $postService;
    protected $subscriberService;

    public function boot(
        Post $post,
        AlertService $alertService,
        PostService $postService,
        SubscriberService $subscriberService
    ) {
        $this->post = $post;
        $this->alertService = $alertService;
        $this->postService = $postService;
        $this->subscriberService = $subscriberService;
    }

    public function deletePost(Post $post)
    {
        try {
            DB::transaction(function () use ($post) {
                $this->postService->destroy($post);
            });

            $this->dispatch('post-event');
            $this->alertService->alert($this, config('messages.post.destroy'), 'success');
        } catch (\Throwable $e) {
            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    public function sendMailToSubscribers(Post $post)
    {
        $this->subscriberService->sendNewPostMailToAll($post);
        $this->alertService->alert($this, config('messages.email.new_post_announce'), 'success');
    }

    public function toggleFeature(Post $post)
    {
        defer(fn() => $this->postService->toggleIsFeature($post));

        $this->dispatch('post-event');
        $this->alertService->alert($this, config('messages.common.success'), 'success');
    }

    #[On('post-event')]
    public function render()
    {
        $posts = $this->post->getAllPerFive();

        return view('livewire.post.index', [
            'posts' => $posts
        ])->title('Admin');
    }
}
