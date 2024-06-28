<?php

namespace App\Livewire\Post;

use App\Models\Post;
use App\Mail\PostMail;
use Livewire\Component;
use App\Models\Subscriber;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Index extends Component
{
    use WithPagination;

    public function deletePost(Post $post)
    {
        DB::beginTransaction();

        try {
            // delete related media
            $media = $post->media;

            $media = FileService::deleteFile($media);

            $media->delete();

            // delete its sections
            $sections = $post->sections;

            foreach ($sections as $section) {
                // delete section's all media
                $medias = $section->media;

                foreach ($medias as $media) {
                    $media = FileService::deleteFile($media);

                    $media->delete();
                }

                $section->delete();
            }

            // Remove relationships between post and associated tags
            $post->tags()->detach();

            $post->delete();

            DB::commit();

            $this->dispatch('post-event');
            $this->dispatch('swal', [
                'title' => 'Post deleted successfully !',
                'icon' => 'success',
                'iconColor' => 'green'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('swal', [
                'title' => 'An unexpected error occurred. Please try again later.',
                'icon' => 'error',
                'iconColor' => 'red'
            ]);
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

        $this->dispatch('swal', [
            'title' => 'Successfully sent new post link to subscribers',
            'icon' => 'success',
            'iconColor' => 'green'
        ]);
    }

    #[On('post-event')]
    public function render()
    {
        $posts = Post::with('media', 'topic', 'tags', 'sections')
            ->select('id', 'topic_id', 'heading', 'slug', 'body', 'is_publish', 'created_at')
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.post.index', [
            'posts' => $posts
        ])->title('Admin');
    }
}
