@section('title', 'Anime Fever Zone')
@section('description', 'Anime')

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
                        {{ $post->topic->name }}
                        @foreach ($post->tags as $tag)
                            <span>| {{ $tag->name }}</span>
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

    @section('scripts')
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
    @endsection

</div>
