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
            <img src="{{ $post->media->url }}" alt="Image representing {{ $post->heading }}" class="w-full">
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
                                <x-icons.edit-icon />
                            </span>
                            <button onclick="return confirm('Are you sure to delete?')">
                                {{-- Delete button --}}
                                <x-icons.trash-icon />
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
                    <span
                        class="font-bold text-xs uppercase bg-gray-300 hover:bg-gray-200 rounded p-2">{{ $post->topic->name }}</span>
                    @foreach ($post->tags as $tag)
                        <span
                            class="font-bold text-xs uppercase bg-gray-300 hover:bg-gray-200 rounded p-2">{{ $tag->name }}</span>
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
