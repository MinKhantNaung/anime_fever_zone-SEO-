<aside class="w-full md:w-1/3 flex flex-col items-center px-3">

    @if (request()->routeIs('post'))
        <div class="w-full">
            <span class="bg-rose-500">.</span>
            <span class="text-2xl">You may also like</span>
        </div>
    @else
        <div class="w-full">
            <span class="bg-rose-500">.</span>
            <span class="text-2xl">Popular</span>
        </div>
    @endif

    @foreach ($popularPosts as $post)
        <a wire:navigate.hover href="{{ route('post', $post->slug) }}">
            <div class="grid grid-cols-12 bg-white shadow my-4 p-6">
                <div class="col-span-12 xl:col-span-4">
                    <img src="{{ $post->media->url }}" class="w-full object-cover">
                </div>
                <div class="col-span-12 xl:col-span-8">
                    <p class="px-2 font-extrabold hover:underline">
                        {{ $post->heading }}
                    </p>
                </div>
            </div>
        </a>
    @endforeach

</aside>
