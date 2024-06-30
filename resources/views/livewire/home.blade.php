@section('description', 'Explore exciting content on Anime and more at Anime Fever Zone. Join our community and stay informed about
the latest trends and discussions across a wide range of topics.')

<div class="container mx-auto flex flex-wrap py-6">

    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3 overflow-hidden">

        <div class="w-full">
            <span class="bg-rose-500">.</span>
            <span class="text-2xl">Latest</span>
        </div>

        @foreach ($posts as $post)
            <div class="grid grid-cols-12 gap-1 bg-white shadow my-4">
                <div class="col-span-12 lg:col-span-5">
                    <a wire:navigate.hover href="{{ route('post', $post->slug) }}">
                        <img src="{{ $post->media->url }}" alt="{{ $post->heading }}" class="w-full object-cover">
                    </a>
                </div>

                <div class="col-span-12 lg:col-span-7 ps-1">
                    <p class="font-extrabold text-sm text-[#9926f0] uppercase">
                        <a wire:navigate.hover href="{{ route('topic', $post->topic->slug) }}" class="cursor-pointer">
                            {{ $post->topic->name }}
                        </a>
                        @foreach ($post->tags as $tag)
                            <a wire:navigate.hover href="{{ route('tag', $tag->slug) }}">| {{ $tag->name }}</a>
                        @endforeach
                    </p>

                    <a wire:navigate.hover href="{{ route('post', $post->slug) }}">
                        <h1 class="font-black text-2xl capitalize my-2">
                            {{ $post->heading }}
                        </h1>

                        <p class="font-bold hover:underline text-base">
                            {!! Str::limit($post->body, 140) !!}
                        </p>

                        <p class="text-xs mt-2">By Anime Fever Zone | {{ $post->created_at->diffForHumans() }}</p>
                    </a>
                </div>
            </div>
        @endforeach

        @if ($posts->count() < 1)
            <p class="mt-20 text-4xl">Currently, there are no posts available.</p>
        @endif

        <div class="w-full">
            {{ $posts->links() }}
        </div>

    </section>

    <!-- other posts Section -->
    <x-other-posts :popularPosts="$popularPosts" />

    @push('scripts')
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "BlogPosting",
          "headline": "Anime Fever Zone",
          "image": "{{ asset('favicon.ico') }}",
          "description": "Explore the latest news, reviews, and discussions on anime and other popular series at Anime Fever Zone. Stay up-to-date
          with the hottest trends and join our vibrant community of anime enthusiasts.",
          "author": {
            "@type": "Person",
            "name": "Anime Fever Zone"
          }
        }
        </script>
    @endpush

</div>
