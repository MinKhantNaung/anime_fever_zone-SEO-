@section('title', 'Admin')

<div class="container mx-auto flex flex-wrap py-6 overflow-x-auto">

    <button onclick="Livewire.dispatch('openModal', { component: 'post.create' })" class="btn btn-secondary ml-auto">+
        Create
        New</button>

    @if ($posts->count() > 0)
        <div class="w-full mt-3">
            {{ $posts->links(data: ['scrollTo' => false]) }}
        </div>

        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Topic</th>
                    <th>Tags</th>
                    <th>Heading</th>
                    <th>Slug</th>
                    <th>Body</th>
                    <th>Publish</th>
                    <th>Sections</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $index => $post)
                    <tr>
                        <td>{{ $index + $posts->firstItem() }}</td>
                        <td class="w-[200px]">
                            <img src="{{ $post->media->url }}" alt="post image" class="w-full">
                        </td>
                        <td>{{ $post->topic->name }}</td>
                        <td>
                            @foreach ($post->tags as $tag)
                                <div class="badge badge-primary my-1 text-nowrap">{{ $tag->name }}</div>
                            @endforeach
                        </td>
                        <td class="text-wrap">{{ $post->heading }}</td>
                        <td class="text-wrap">{{ $post->slug }}</td>
                        <td>{{ $post->body }}</td>
                        <td>
                            @if ($post->is_publish == 1)
                                <button wire:loading.attr="disabled" wire:click.prevent='sendMailToSubscribers({{ $post->id }})'
                                    class="btn btn-sm btn-primary">
                                    Send Mail
                                </button>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            @endif
                        </td>
                        {{-- Go to sections --}}
                        <td>
                            <a wire:navigate.hover href="{{ route('sections.index', $post->id) }}"
                                class="rounded-full bg-violet-500 text-white p-2 indicator">
                                <span
                                    class="indicator-item badge badge-secondary">{{ $post->sections->count() }}+</span>
                                Sections
                            </a>
                        </td>
                        <td class="text-nowrap">
                            <form wire:submit.prevent="deletePost({{ $post->id }})">

                                @csrf
                                <span
                                    onclick="Livewire.dispatch('openModal', { component: 'post.edit', arguments: { post: {{ $post->id }} } })"
                                    class="inline-block cursor-pointer">
                                    {{-- Edit button --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </span>
                                <button
                                    onclick="return confirm('Are you sure to delete? This will also delete related sections !!')">
                                    {{-- Delete button --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6">
                                        <path fill-rule="evenodd"
                                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div role="alert" class="alert bg-secondary text-white">
            <span>No posts found !!</span>
        </div>
    @endif

</div>
