@section('title', 'Admin')

<div class="container mx-auto flex flex-wrap py-6 overflow-x-auto">

    <button onclick="Livewire.dispatch('openModal', { component: 'section.create', arguments: { post: {{ $post->id }} } })" class="btn btn-secondary ml-auto">+
        Create
        New</button>

    @if ($post->sections->count() > 0)
        <div class="max-w-lg mx-auto">


        </div>
    @else
        <div role="alert" class="alert bg-secondary text-white">
            <span>No sections found !!</span>
        </div>
    @endif

</div>
