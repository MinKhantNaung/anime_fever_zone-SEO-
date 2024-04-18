@section('title', 'Admin')

<div class="container mx-auto flex flex-wrap py-6">

    <section class="w-full md:w-2/3 flex flex-col items-center px-3">
        <button onclick="Livewire.dispatch('openModal', { component: 'tag.create' })" class="btn btn-secondary">+ Create
            New</button>

        <div class="grid grid-cols-12 w-full my-3">

            @foreach ($tags as $tag)
                <div class="hidden lg:block lg:col-span-4"></div>
                <div class="col-span-12 lg:col-span-4">
                    <img src="{{ $tag->media->url }}" alt="" class="w-[100%]">
                </div>

                <h1 class="col-span-12 text-center font-bold text-xl my-3">
                    {{ $tag->name }}
                </h1>

                <p class="col-span-12 text-lg font-bold">
                    {{ $tag->body }}
                </p>

                <div class="col-span-12 text-center">
                    <form wire:submit.prevent="deleteTag({{ $tag->id }})">

                        @csrf
                        <span class="inline-block cursor-pointer">
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

            <div class="col-span-12">
                {{ $tags->links(data: ['scrollTo' => false]) }}
            </div>

        </div>

    </section>

</div>
