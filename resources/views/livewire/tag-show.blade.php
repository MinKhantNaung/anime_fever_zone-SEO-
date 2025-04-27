@section('description', "Explore exciting content on " . ucfirst(str_replace('-', ' ', $slug)) . " and more at Anime Fever Zone. Join our community and stay informed about
    the latest trends and discussions across a wide range of topics.")

@section('meta-og')
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Anime Fever Zone-{{ ucfirst($slug) }}" />
    <meta property="og:description"
        content="Explore exciting content on {{ ucfirst(str_replace('-', ' ', $slug)) }} and more at Anime Fever Zone. Join our community and stay informed about
    the latest trends and discussions across a wide range of topics." />
    <meta property="og:image" content="{{ $tag->media->url }}" />
    <meta property="og:image:secure_url" content="{{ $tag->media->url }}" />
    <meta property="og:image:width" content="630" />
    <meta property="og:image:height" content="1200" />
@endsection

<div class="container mx-auto flex flex-wrap py-6">

    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3 overflow-hidden">
        {{-- show tag --}}
        <div class="grid grid-cols-12 w-full my-3">
            <div class="hidden lg:block lg:col-span-4"></div>
            <div class="col-span-12 lg:col-span-4">
                <img src="{{ $tag->media->url }}" alt="{{ $tag->name }}" class="w-[100%]">
            </div>

            <h1 class="col-span-12 text-center font-bold text-2xl my-3">
                {{ $tag->name }}
            </h1>

            <p class="col-span-12 text-lg font-medium text-gray-700 leading-9">
                {!! $tag->body !!}
            </p>
        </div>

        <div class="w-full">
            <span class="bg-rose-500">.</span>
            <span class="text-2xl">Latest</span>
        </div>

        @foreach ($this->posts as $post)
            <div class="grid grid-cols-12 gap-1 bg-white shadow-sm my-4">
                <div class="col-span-12 lg:col-span-5">
                    <a wire:navigate href="{{ route('post', $post->slug) }}">
                        <img src="{{ $post->media->url }}" class="w-full object-cover">
                    </a>
                </div>

                <div class="col-span-12 lg:col-span-7">
                    <p class="font-extrabold text-sm text-[#9926f0] uppercase">
                        <a wire:navigate href="{{ route('topic', $post->topic->slug) }}" class="cursor-pointer">
                            {{ $post->topic->name }}
                        </a>
                        @foreach ($post->tags as $tag)
                            <a wire:navigate href="{{ route('tag', $tag->slug) }}">| {{ $tag->name }}</a>
                        @endforeach
                    </p>

                    <a wire:navigate href="{{ route('post', $post->slug) }}">
                        <h1 class="font-black text-2xl capitalize my-2">
                            {{ $post->heading }}
                        </h1>

                        <p class="font-bold hover:underline text-base">
                            {!! Str::limit($post->body, 140) !!}
                        </p>

                        <p class="text-xs mt-2">By Anime Fever Zone | {{ $post->updated_at->diffForHumans() }}</p>
                    </a>
                </div>
            </div>
        @endforeach

        @if ($this->posts->count() < 1)
            <p class="mt-20 text-4xl">Currently, there are no posts available.</p>
        @endif

        <div class="w-full">
            {{ $this->posts->links() }}
        </div>

    </section>

    <!-- other posts Section -->
    <x-other-posts :featuredPosts="$featuredPosts" />

</div>

@push('scripts')

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": "{{ ucfirst($slug) . ' | Anime Fever Zone' }}",
      "image": "{{ asset('favicon.ico') }}",
      "description": "Explore exciting content on {{ $slug }} and more at Anime Fever Zone. Join our community and stay informed about
      the latest trends and discussions across a wide range of topics.",
      "author": {
        "@type": "Person",
        "name": "Anime Fever Zone"
      }
    }
    </script>
@endpush
