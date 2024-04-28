@section('title', ucfirst($slug) . ' | Anime Fever Zone')
@section('description')
    Explore exciting content on {{ ucfirst(str_replace('-', ' ', $slug)) }} and more at Anime Fever Zone. Join our community and stay informed about
    the latest trends and discussions across a wide range of topics.
@endsection

<div class="container mx-auto flex flex-wrap py-6">

    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3 overflow-hidden">

        {{-- show tag --}}
        <div class="grid grid-cols-12 w-full my-3">
            <div class="hidden lg:block lg:col-span-4"></div>
            <div class="col-span-12 lg:col-span-4">
                <img src="{{ $tag->media->url }}" alt="" class="w-[100%]">
            </div>

            <h1 class="col-span-12 text-center font-bold text-2xl my-3">
                {{ $tag->name }}
            </h1>

            <p class="col-span-12 text-lg font-medium">
                {!! $tag->body !!}
            </p>
        </div>

        @foreach ($posts as $post)
            <div class="grid grid-cols-12 gap-1 bg-white shadow my-4">
                <div class="col-span-12 lg:col-span-5">
                    <a wire:navigate.hover href="{{ route('post', $post->slug) }}">
                        <img src="{{ $post->media->url }}" class="w-full object-cover">
                    </a>
                </div>

                <div class="col-span-12 lg:col-span-7">
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
                            {{ Str::limit($post->body, 100) }}
                        </p>

                        <p class="text-xs mt-2">By Anime Fever Zone | {{ $post->created_at->diffForHumans() }}</p>
                    </a>
                </div>
            </div>
        @endforeach

        <div class="w-full">
            {{ $posts->links() }}
        </div>

    </section>

    <!-- other posts Section -->
    <x-other-posts :popularPosts="$popularPosts" />

</div>

@section('script')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": "{{ ucfirst($slug) . ' | Anime Fever Zone' }}",
      "image": "{{ $tag->media->url }}",
      "description": "Explore exciting content on {{ $slug }} and more at Anime Fever Zone. Join our community and stay informed about
      the latest trends and discussions across a wide range of topics.",
      "author": {
        "@type": "Person",
        "name": "Anime Fever Zone"
      }
    }
    </script>
@endsection
