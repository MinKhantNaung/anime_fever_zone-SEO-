<?php

namespace App\Livewire\Post;

use App\Models\Post;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function deletePost(Post $post)
    {
        DB::beginTransaction();

        try {
            // delete related media
            $media = $post->media;

            $media = (new FileService)->deleteFile($media);

            $media->delete();

            // delete its sections
            $sections = $post->sections;

            foreach ($sections as $section) {
                // delete section's all media
                $medias = $section->media;

                foreach ($medias as $media) {
                    $media = (new FileService)->deleteFile($media);

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

    #[On('post-event')]
    public function render()
    {
        $posts = Post::with('media', 'topic', 'tags', 'sections', 'comments')
            ->select('id', 'topic_id', 'heading', 'slug', 'body', 'is_publish', 'created_at')
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.post.index', [
            'posts' => $posts
        ]);
    }
}
