<div class="container mx-auto flex flex-wrap py-6 overflow-x-auto">

    <div class="w-[320px] mx-auto text-center">

        <h1>Topic</h1>

        <form wire:submit.prevent="createOrUpdateTopic()">
            <label class="input input-bordered flex items-center gap-2">
                <x-icons.info-icon />
                <input wire:model="name" type="text" class="grow" placeholder="Topic name" />
            </label>

            @error('name')
                <x-input-error :messages="$message" />
            @enderror

            <button @disabled($topics->count() > 2 && $editMode == false) wire:loading.attr='disabled' type="submit"
                class="btn btn-secondary my-5">Submit</button>
        </form>
    </div>

    @if ($topics->count() > 0)
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topics as $topic)
                    <tr>
                        <th>{{ $topic->id }}</th>
                        <td class="text-nowrap">{{ $topic->name }}</td>
                        <td class="text-nowrap">{{ $topic->slug }}</td>
                        <td class="text-nowrap">
                            <form wire:submit.prevent="deleteTopic({{ $topic->id }})">

                                @csrf
                                <span wire:click.prevent="updateEditMode({{ $topic->id }})" class="inline-block cursor-pointer">
                                    {{-- Edit button --}}
                                    <x-icons.edit-icon />
                                </span>
                                <button onclick="return confirm('Are you sure to delete? This will also delete related posts !!')">
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
            <span>No topics found !!</span>
        </div>
    @endif

</div>
