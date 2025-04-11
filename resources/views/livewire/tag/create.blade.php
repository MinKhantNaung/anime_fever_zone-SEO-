<div class="bg-white lg:h-[500px] flex flex-col border gap-y-4 px-5">

    <header class="w-full py-2 border-b">
        <div class="flex justify-between">
            <button wire:click="$dispatch('closeModal')" class="font-bold">
                <x-icons.close-icon />
            </button>

            <div class="text-lg font-bold">
                Create new tag
            </div>

            <button wire:loading.attr='disabled' wire:click.prevent='createTag' type="button"
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
                <h1 class="text-center">Recommend Potrait Image like Phone screen</h1>
                <label for="custom-file-input" class="m-auto max-w-fit flex-col flex gap-3 cursor-pointer">
                    <input wire:model.live='media' type="file" accept=".jpg,.jpeg,.png,.svg,.webp"
                        id="custom-file-input" class="sr-only">

                    <span class="m-auto mt-1">
                        <x-icons.potrait-image-icon />
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

        <aside class="col-span-12 lg:col-span-5 m-auto items-center w-full">
            <div>
                <label class="input input-bordered flex items-center gap-2">
                    Name
                    <input wire:model="name" type="text" class="grow" placeholder="Enter tag name" />
                </label>
                @error('name')
                    <x-input-error messages="{{ $message }}" />
                @enderror

                <textarea wire:model="body" class="textarea textarea-primary w-full mt-3" placeholder="Enter description"></textarea>
                @error('body')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>
        </aside>

    </main>

</div>
