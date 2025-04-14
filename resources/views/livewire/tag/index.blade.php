<div class="container mx-auto flex flex-wrap py-6">

    <section class="w-full md:w-2/3 flex flex-col items-center px-3">
        <a href="{{ route('tags.create') }}" class="btn btn-secondary">
            + Create New
        </a>

        <div class="grid grid-cols-12 w-full my-3">

            @foreach ($tags as $tag)
                <div class="hidden lg:block lg:col-span-4"></div>
                <div class="col-span-12 lg:col-span-4">
                    <img src="{{ optional($tag->media)->url }}" alt="Image representing {{ $tag->name }}"
                        class="w-[100%]">
                </div>

                <h1 class="col-span-12 text-center font-bold text-2xl my-3">
                    {{ $tag->name }}
                </h1>

                <div class="col-span-12 text-lg anime-content">
                    {!! $tag->body !!}
                </div>

                <div class="col-span-12 text-center">
                    <form wire:submit.prevent="deleteTag({{ $tag->id }})">

                        @csrf
                        <a href="{{ route('tags.edit', $tag->id) }}" class="inline-block cursor-pointer">
                            {{-- Edit button --}}
                            <x-icons.edit-icon />
                        </a>
                        <button onclick="return confirm('Are you sure to delete?')">
                            {{-- Delete button --}}
                            <x-icons.trash-icon />
                        </button>
                    </form>
                </div>
            @endforeach

            <div class="col-span-12">
                {{ $tags->links(data: ['scrollTo' => false]) }}
            </div>

        </div>

    </section>

</div>
