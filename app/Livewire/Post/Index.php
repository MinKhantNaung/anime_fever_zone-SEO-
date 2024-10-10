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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function Illuminate\Support\defer;

class Index extends Component
{
    use WithPagination;

    protected $post;
    protected $alertService;
    protected $postService;

    public function boot(Post $post, AlertService $alertService, PostService $postService)
    {
        $this->post = $post;
        $this->alertService = $alertService;
        $this->postService = $postService;
    }

    public function deletePost(Post $post)
    {
        DB::beginTransaction();

        try {
            $this->postService->destroy($post);
            DB::commit();

            $this->dispatch('post-event');
            $this->alertService->alert($this, config('messages.post.destroy'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    public function sendMailToSubscribers(Post $post)
    {
        // Send email
        $subject = 'Your Daily Dose of [Anime Fever Zone]: New Post Alert!';
        $new_post_link = url($post->slug . '/post');
        $body = "<p style='font-weight: bolder; font-size: 25px;'>$post->heading</p>";
        $body .= "Click on the following link to read <br>";

        $body .= '<a href="' . $new_post_link . '">';
        $body .= $new_post_link;
        $body .= '</a>';

        $subscribers = Subscriber::where('status', 'Active')->get();

        // $subscribers->chunk(100, function ($batch) use ($subject, $message, $post) {
        //     foreach ($batch as $subscriber) {
        //         Mail::to($subscriber->email)->send(new PostMail($subject, $message, $post->media->url));
        //     }
        // });

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new PostMail($subject, $body, $post->media->url));
        }

        $this->alertService->alert($this, config('messages.email.new_post_announce'), 'success');
    }

    public function toggleFeature(Post $post)
    {
        defer(fn () => $this->postService->toggleIsFeature($post));

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
