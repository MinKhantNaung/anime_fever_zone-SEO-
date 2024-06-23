@section('description', substr($post->body, 0, 150) . "...")

<div class="container mx-auto flex flex-wrap py-6">

    <section class="w-full md:w-2/3 flex flex-col items-center px-3">

        <article class="flex flex-col my-4 w-full">
            <h1 class="text-3xl sm:text-5xl font-black leading-tight text-gray-800">{{ $post->heading }}</h1>
            <div class="bg-white flex flex-col justify-start">
                <p class="text-xs py-6 uppercase">
                    By <span class="font-bold mr-2">Anime Fever Zone</span>
                    Published {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
            <!-- Article Image -->
            <img src="{{ $post->media->url }}" alt="{{ $post->heading }}" class="w-full">
            <!-- Post Description -->
            <p class="pb-3 pt-6 text-lg font-medium">{!! $post->body !!}</p>

            @foreach ($post->sections as $section)
                <livewire:section.item wire:key="{{ $section->id }}" :section="$section" />
            @endforeach

            <div>
                <h1 class="text-xl italic font-extrabold my-2">Related Topics</h1>
                <div>
                    <a wire:navigate.hover href="{{ route('topic', $post->topic->slug) }}"
                        class="font-bold text-xs uppercase bg-gray-300 hover:bg-gray-200 rounded p-2">{{ $post->topic->name }}</a>
                    @foreach ($post->tags as $tag)
                        <a wire:navigate.hover href="{{ route('tag', $tag->slug) }}"
                            class="font-bold text-xs uppercase bg-gray-300 hover:bg-gray-200 rounded p-2">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>

            <livewire:comments :model="$post"/>

            {{-- Subscriber Form --}}
            <div class="w-full bg-gray-400 mt-5 rounded-lg py-5 px-4 text-xl font-extrabold">
                <h1>Subscribe To Our Newletter!</h1>
                <input wire:model='email' type="email" class="mt-5 focus:ring-0 w-full text-lg" placeholder="Email Address">
                @error('email')
                    <x-input-error messages="{{ $message }}" />
                @enderror
                <button wire:loading.attr='disabled' wire:click.prevent='subscribe' class="btn btn-secondary text-lg mt-5">
                    Subscribe
                </button>
            </div>

        </article>

    </section>

    <!-- other posts Section -->
    <x-other-posts :$popularPosts />

</div>

@push('scripts')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": "{{ ucwords(str_replace('-', ' ', $slug)) }}",
      "image": "{{ $post->media->url }}",
      "description": "{{ substr($post->body, 0, 150) }}",
      "author": {
        "@type": "Person",
        "name": "Anime Fever Zone"
      }
    }
    </script>
@endpush
