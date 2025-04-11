<div class="bg-white lg:h-[500px] flex flex-col border gap-y-4 px-5">

    <header class="w-full py-2 border-b">
        <div class="flex justify-between">
            <button wire:click="$dispatch('closeModal')" class="font-bold">
                <x-icons.close-icon />
            </button>

            <div class="text-lg font-bold">
                Add New Section
            </div>

            <button wire:loading.attr='disabled' wire:click.prevent='addSection' type="button"
                class="text-blue-500 font-bold">
                Submit
            </button>
        </div>
    </header>

    <main class="grid grid-cols-12 gap-3 h-full w-full overflow-hidden">

        {{-- Media --}}
        {{-- left side --}}
        <aside class="col-span-12 lg:col-span-7 m-auto items-center w-full overflow-scroll">

            @if (count($media) == 0)
                {{-- Trigger Button --}}
                <h1 class="text-center">16:9 aspect ratio, recommended like TV screen</h1>
                <label for="custom-file-input" class="m-auto max-w-fit flex-col flex gap-3 cursor-pointer">
                    <input wire:model.live='media' type="file" multiple accept=".jpg,.jpeg,.png,svg,webp"
                        id="custom-file-input" class="sr-only">

                    <span class="m-auto">
                        <x-icons.hori-image-icon />
                    </span>

                    <span class="bg-blue-500 text-white text-sm rounded-lg p-2 px-4">
                        Upload files
                    </span>
                </label>
            @else
                {{-- Show if file count is > 0 --}}
                <div class="flex overflow-x-scroll w-[500px] h-96 snap-x snap-mandatory gap-2 px-2">
                    @foreach ($media as $index => $file)
                        <div class="w-full h-full shrink-0 snap-always snap-center">
                            @if (strpos($file->getMimeType(), 'image') !== false)
                                <img src="{{ $file->temporaryUrl() }}" alt=""
                                    class="w-full h-full object-contain">
                            @elseif (strpos($file->getMimeType(), 'video') !== false)
                                <x-video :source="$file->temporaryUrl()" />
                            @endif
                        </div>
                    @endforeach
                </div>

                @error('media.*')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            @endif

        </aside>

        <aside class="col-span-12 lg:col-span-5 mx-auto items-center w-full">
            <div>
                <input wire:model="heading" type="text" placeholder="Type heading (optional)"
                    class="input input-bordered input-primary w-full mt-3" />
                @error('heading')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>

            <div>
                <textarea wire:model="body" class="textarea textarea-primary w-full mt-3" placeholder="Enter description"></textarea>
                @error('body')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>
        </aside>

    </main>

</div>
