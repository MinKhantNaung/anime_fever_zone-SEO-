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

            @if ($post->sections->count() > 0)
                @foreach ($post->sections as $section)
                    <livewire:section.item wire:key="{{ $section->id }}" :section="$section" />

                    <div class="text-center mt-3">
                        <form wire:submit.prevent="removeSection({{ $section->id }})">

                            @csrf
                            <span
                                onclick="Livewire.dispatch('openModal', { component: 'section.edit', arguments: { section: {{ $section->id }} } })"
                                class="inline-block cursor-pointer">
                                {{-- Edit button --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </span>
                            <button onclick="return confirm('Are you sure to delete?')">
                                {{-- Delete button --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            @else
                <div role="alert" class="alert bg-secondary text-white">
                    <span>No sections found !!</span>
                </div>
            @endif

            <div>
                <h1 class="text-xl italic font-extrabold mb-2">Related Topics</h1>
                <div>
                    <a href="#"
                        class="font-bold text-xs uppercase bg-gray-300 hover:bg-gray-200 rounded p-2">{{ $post->topic->name }}</a>
                    @foreach ($post->tags as $tag)
                        <a href="#"
                            class="font-bold text-xs uppercase bg-gray-300 hover:bg-gray-200 rounded p-2">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
        </article>

        <button
            onclick="Livewire.dispatch('openModal', { component: 'section.create', arguments: { post: {{ $post->id }} } })"
            class="btn btn-secondary ml-auto">+
            Add New Section
        </button>

    </section>

</div>
