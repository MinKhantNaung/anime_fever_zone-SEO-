@section('title', 'Anime Fever Zone-' . ucfirst($slug))
@section('description')
    @switch($slug)
        @case('anime')
            Explore the latest news, reviews, and discussions on anime and other popular series at Anime Fever Zone. Stay up-to-date
            with the hottest trends and join our vibrant community of anime enthusiasts.
        @break

        @case('sport')
            Discover the latest updates, analyses, and highlights from the world of sports at Anime Fever Zone. Whether you're a fan
            of soccer, basketball, or any other sport, we've got you covered with in-depth coverage and insightful commentary.
        @break

        @case('movie')
            Dive into the world of cinema with Anime Fever Zone. From blockbuster hits to indie gems, explore movie reviews,
            trailers, and exclusive interviews with filmmakers. Get your popcorn ready and join us on a cinematic journey like no
            other.
        @break

        @case('wwe')
            Immerse yourself in the thrilling world of WWE (World Wrestling Entertainment) at Anime Fever Zone. Catch up on the
            latest matches, rumors, and behind-the-scenes insights from the world of professional wrestling. Join our passionate
            community of WWE fans and experience the excitement firsthand.
        @break

        @default
            Explore exciting content on {{ $slug }} and more at Anime Fever Zone. Join our community and stay informed about
            the latest trends and discussions across a wide range of topics.
    @endswitch
@endsection

<div class="container mx-auto flex flex-wrap py-6">

    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3 overflow-hidden">

        @foreach ($posts as $post)
            <div class="grid grid-cols-12 gap-1 bg-white shadow my-4">
                <div class="col-span-12 lg:col-span-5">
                    <img src="{{ $post->media->url }}" class="w-full object-cover">
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

                    <h1 class="font-black text-2xl capitalize my-2">
                        {{ $post->heading }}
                    </h1>

                    <p class="font-bold hover:underline text-base">
                        {{ Str::limit($post->body, 100) }}
                    </p>

                    <p class="text-xs mt-2">By Anime Fever Zone | {{ $post->created_at->diffForHumans() }}</p>
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
      "headline": "{{ 'Anime Fever Zone' . ucfirst($slug) }}",
      "image": "{{ asset('favicon.ico') }}",
      "description": "Explore exciting content on {{ $slug }} and more at Anime Fever Zone. Join our community and stay informed about
      the latest trends and discussions across a wide range of topics.",
      "author": {
        "@type": "Person",
        "name": "Anime Fever Zone"
      }
    }
    </script>
@endsection