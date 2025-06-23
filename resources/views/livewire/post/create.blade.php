<div class="relative bg-white lg:h-[500px] flex flex-col border gap-y-4 px-5">

    <header class="w-full py-2 border-b">
        <div class="flex justify-between">
            <button wire:click="$dispatch('closeModal')" class="font-bold">
                <x-icons.close-icon />
            </button>

            <div class="text-lg font-bold">
                Create new post
            </div>

            <button wire:loading.attr='disabled' wire:click.prevent='createPost' type="button"
                class="text-blue-500 font-bold">
                Submit
            </button>
        </div>
    </header>

    <main class="grid grid-cols-12 gap-3 h-full w-full overflow-hidden">

        {{-- Media --}}
        {{-- left side --}}
        <aside class="col-span-12 lg:col-span-7 m-auto items-center w-full overflow-scroll">

            @if (!$media)
                {{-- Trigger Button --}}
                <h1 class="text-center">16:9 aspect ratio, recommended like TV screen</h1>
                <label for="custom-file-input" class="m-auto max-w-fit flex-col flex gap-3 cursor-pointer">
                    <input wire:model.live='media' type="file" accept=".jpg,.jpeg,.png,.svg,.webp"
                        id="custom-file-input" class="sr-only">

                    <span class="m-auto">
                        <x-icons.hori-image-icon />
                    </span>

                    <span class="bg-blue-500 text-white text-sm rounded-lg p-2 px-4">
                        Upload Image
                    </span>
                </label>
                @error('media')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            @else
                {{-- Show if file count is > 0 --}}
                <div class="flex overflow-x-scroll w-[500px] h-96 snap-x snap-mandatory gap-2 px-2">
                    <div class="w-full h-full shrink-0 snap-always snap-center">
                        <img src="{{ $media->temporaryUrl() }}" alt="tag image" class="w-full h-full object-contain">
                    </div>
                </div>

                @error('media')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            @endif

        </aside>

        {{-- right side --}}
        <aside class="col-span-12 lg:col-span-5 mx-auto w-full">
            <div>
                <select wire:model="topic_id" class="select select-primary w-full">
                    <option selected>Pick topic</option>
                    @foreach ($topics as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('topic_id')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>

            <div class="mt-3">
                <select wire:model="selectedTags" class="select select-primary w-full" multiple>
                    <option disabled selected>Select tags (Optional)</option>
                    @foreach ($tags as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <input wire:model="heading" type="text" placeholder="Type heading"
                    class="input border-primary w-full" />
                @error('heading')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>

            <div class="mt-3">
                <textarea wire:model="body" class="textarea textarea-primary w-full" placeholder="Type description"></textarea>
                @error('body')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>

            <div class="form-control mt-3">
                <label class="label cursor-pointer">
                    <span class="label-text">Publish</span>
                    <input wire:model="is_publish" type="checkbox" class="checkbox checkbox-primary" />
                </label>
            </div>
        </aside>

    </main>

</div>
