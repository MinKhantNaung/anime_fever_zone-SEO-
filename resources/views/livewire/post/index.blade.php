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
                    <th>Show As Features</th>
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
                        <td>
                            <input wire:change="toggleFeature({{ $post->id }})" type="checkbox" class="checkbox checkbox-primary" {{ $post->is_feature ? 'checked' : '' }} />
                        </td>
                        <td>{{ $index + $posts->firstItem() }}</td>
                        <td class="w-[200px]">
                            <img src="{{ $post->media->url }}" alt="Image representing {{ $post->heading }}" class="w-full">
                        </td>
                        <td>{{ $post->topic->name }}</td>
                        <td>
                            @foreach ($post->tags as $tag)
                                <div class="badge badge-primary my-1 text-nowrap">{{ $tag->name }}</div>
                            @endforeach
                        </td>
                        <td class="text-wrap">{{ $post->heading }}</td>
                        <td class="text-wrap">{{ $post->slug }}</td>
                        <td>{!! $post->body !!}</td>
                        <td>
                            @if ($post->is_publish == 1)
                                <button wire:loading.attr="disabled" wire:click.prevent='sendMailToSubscribers({{ $post->id }})'
                                    class="btn btn-sm btn-primary">
                                    Send Mail
                                </button>
                            @else
                                <x-icons.close-icon />
                            @endif
                        </td>
                        {{-- Go to sections --}}
                        <td>
                            <a wire:navigate href="{{ route('sections.index', $post->id) }}"
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
                                    <x-icons.edit-icon />
                                </span>
                                <button
                                    onclick="return confirm('Are you sure to delete? This will also delete related sections !!')">
                                    {{-- Delete button --}}
                                    <x-icons.trash-icon />
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
