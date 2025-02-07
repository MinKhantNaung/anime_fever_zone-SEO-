<div>
    <section class="bg-white dark:bg-gray-900 py-8 lg:py-16">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion
                    ({{ $comments->count() }})</h2>
            </div>
            @auth
                @include('livewire.partials.comment-form', [
                    'users' => $users,
                    'method' => 'postComment',
                    'state' => 'newCommentState',
                    'inputId' => 'comment',
                    'inputLabel' => 'Your comment',
                    'button' => 'Post comment',
                ])
            @else
                <a wire:navigate class="mt-2 text-sm" href="/login">Log in to comment!</a>
            @endauth
            @if ($comments->count())
                @foreach ($comments as $comment)
                    <livewire:comment-feature.comment :$comment :key="$comment->id" />
                @endforeach
                {{ $comments->links(data: ['scrollTo' => false]) }}
            @else
                <p>No comments yet!</p>
            @endif
        </div>
    </section>
</div>
