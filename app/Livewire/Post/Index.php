<?php

namespace App\Livewire\Post;

use App\Models\Post;
use App\Mail\PostMail;
use Livewire\Component;
use App\Models\Subscriber;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Services\FileService;
use App\Services\AlertService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Index extends Component
{
    use WithPagination;

    protected $alertService;
    protected $fileService;

    public function boot(AlertService $alertService, FileService $fileService)
    {
        $this->alertService = $alertService;
        $this->fileService = $fileService;
    }

    public function deletePost(Post $post)
    {
        DB::beginTransaction();

        try {
            // delete related media
            $media = $post->media;

            $media = $this->fileService->deleteFile($media);

            $media->delete();

            // delete its sections
            $sections = $post->sections;

            foreach ($sections as $section) {
                // delete section's all media
                $medias = $section->media;

                foreach ($medias as $media) {
                    $media = $this->fileService->deleteFile($media);

                    $media->delete();
                }

                $section->delete();
            }

            // Remove relationships between post and associated tags
            $post->tags()->detach();

            $post->delete();

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
        $post->update([
            'is_feature' => !$post->is_feature
        ]);

        $this->dispatch('post-event');
        $this->alertService->alert($this, config('messages.common.success'), 'success');
    }

    #[On('post-event')]
    public function render()
    {
        $posts = Post::query()
                    ->getAll()
                    ->paginate(5);

        return view('livewire.post.index', [
            'posts' => $posts
        ])->title('Admin');
    }
}
